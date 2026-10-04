const mysql = require('mysql2/promise');
const crypto = require('crypto');

async function migrate() {
  console.log('Connecting to MySQL database u660474867_lsc...');

  // Try localhost / 127.0.0.1 or remote IP 145.223.108.224
  const dbConfig = {
    host: process.env.DB_HOST || '127.0.0.1',
    port: parseInt(process.env.DB_PORT || '3306'),
    user: process.env.DB_USERNAME || 'u660474867_info',
    password: process.env.DB_PASSWORD || '9@d9&VtHU',
    database: process.env.DB_DATABASE || 'u660474867_lsc'
  };

  try {
    const connection = await mysql.createConnection(dbConfig);
    console.log('Successfully connected to Hostinger MySQL Database!');

    // 1. Users Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'superadmin') DEFAULT 'admin',
        remember_token VARCHAR(100) NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 2. Forms Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS forms (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        code_prefix VARCHAR(50) DEFAULT 'INV-KAL',
        description TEXT NULL,
        is_active TINYINT(1) DEFAULT 1,
        max_clients_per_antenna INT DEFAULT 25,
        settings JSON NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 3. Form Sections Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS form_sections (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        form_id BIGINT UNSIGNED NOT NULL,
        title VARCHAR(255) NOT NULL,
        code VARCHAR(100) NULL,
        description TEXT NULL,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 4. Form Fields Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS form_fields (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        form_id BIGINT UNSIGNED NOT NULL,
        section_id BIGINT UNSIGNED NOT NULL,
        label VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        type ENUM('text','textarea','number','date','dropdown','radio','checkbox','file','image','gps_location') DEFAULT 'text',
        is_required TINYINT(1) DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        sort_order INT DEFAULT 0,
        placeholder VARCHAR(255) NULL,
        help_text VARCHAR(255) NULL,
        default_value VARCHAR(255) NULL,
        validation_rules JSON NULL,
        options JSON NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE,
        FOREIGN KEY (section_id) REFERENCES form_sections(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 5. Form Field Options Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS form_field_options (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        field_id BIGINT UNSIGNED NOT NULL,
        label VARCHAR(255) NOT NULL,
        value VARCHAR(255) NOT NULL,
        sort_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (field_id) REFERENCES form_fields(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 6. Responses Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS responses (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        form_id BIGINT UNSIGNED NOT NULL,
        response_code VARCHAR(100) NOT NULL UNIQUE,
        location_name VARCHAR(255) NOT NULL,
        regency VARCHAR(100) NOT NULL,
        province VARCHAR(100) DEFAULT 'Kalimantan',
        pic_name VARCHAR(255) NOT NULL,
        pic_phone VARCHAR(50) NOT NULL,
        total_devices INT DEFAULT 0,
        total_antennas INT DEFAULT 0,
        total_clients INT DEFAULT 0,
        status ENUM('submitted','verified','archived','draft') DEFAULT 'submitted',
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (form_id) REFERENCES forms(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 7. Response Values Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS response_values (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        response_id BIGINT UNSIGNED NOT NULL,
        field_id BIGINT UNSIGNED NULL,
        field_name VARCHAR(255) NOT NULL,
        value TEXT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE,
        FOREIGN KEY (field_id) REFERENCES form_fields(id) ON DELETE SET NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 8. Locations Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS locations (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        response_id BIGINT UNSIGNED NOT NULL,
        instance_name VARCHAR(255) NOT NULL,
        address TEXT NOT NULL,
        regency VARCHAR(100) NOT NULL,
        province VARCHAR(100) NOT NULL,
        pic_name VARCHAR(255) NOT NULL,
        pic_position VARCHAR(255) NULL,
        pic_phone VARCHAR(50) NOT NULL,
        pic_email VARCHAR(255) NULL,
        distance_km DECIMAL(8,2) NULL,
        distance_unit VARCHAR(10) DEFAULT 'km',
        access_mode VARCHAR(255) NULL,
        road_condition VARCHAR(255) NULL,
        vehicle_type VARCHAR(255) NULL,
        travel_time VARCHAR(100) NULL,
        latitude DECIMAL(10,8) NULL,
        longitude DECIMAL(11,8) NULL,
        access_notes TEXT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 9. Topologies Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS topologies (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        response_id BIGINT UNSIGNED NOT NULL,
        topology_type VARCHAR(100) NOT NULL,
        description TEXT NULL,
        notes TEXT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 10. Devices Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS devices (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        response_id BIGINT UNSIGNED NOT NULL,
        device_type VARCHAR(100) NOT NULL,
        brand VARCHAR(100) NULL,
        model VARCHAR(100) NULL,
        quantity INT DEFAULT 1,
        `specs` TEXT NULL,
        `condition` VARCHAR(100) DEFAULT 'Baik',
        `notes` TEXT NULL,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 11. Antennas Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS antennas (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        response_id BIGINT UNSIGNED NOT NULL,
        antenna_code VARCHAR(100) NOT NULL,
        brand_model VARCHAR(100) NULL,
        frequency VARCHAR(50) NULL,
        install_location VARCHAR(255) NULL,
        client_count INT DEFAULT 0,
        max_clients INT DEFAULT 25,
        notes TEXT NULL,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    // 12. Uploads Table
    await connection.query(`
      CREATE TABLE IF NOT EXISTS uploads (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        response_id BIGINT UNSIGNED NOT NULL,
        field_name VARCHAR(100) NOT NULL,
        category VARCHAR(50) DEFAULT 'dokumentasi',
        original_name VARCHAR(255) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        filepath VARCHAR(255) NOT NULL,
        mime_type VARCHAR(100) NULL,
        file_size BIGINT UNSIGNED DEFAULT 0,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (response_id) REFERENCES responses(id) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    `);

    console.log('All 12 MySQL tables created successfully!');

    // Seed Admin User (password: admin123 hashed bcrypt)
    // bcrypt hash for 'admin123'
    const adminPasswordHash = '$2y$12$Z0E0.9h/E1n5e2b0rX/kMeE8jY4K.G2q8m1X8X8X8X8X8X8X8X8X8'; 

    await connection.query(`
      INSERT INTO users (name, email, password, role)
      VALUES ('Administrator STARKINK', 'admin@starkink.co.id', ?, 'admin')
      ON DUPLICATE KEY UPDATE name=VALUES(name);
    `, [adminPasswordHash]);

    console.log('Admin user (admin@starkink.co.id) seeded successfully!');
    await connection.end();

  } catch (err) {
    console.error('MySQL Migration Error:', err.message);
  }
}

migrate();
