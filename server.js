const express = require('express');
const fs = require('fs');
const path = require('path');
const multer = require('multer');

const app = express();
const PORT = process.env.PORT || 8000;

app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));
app.use('/storage', express.static(path.join(__dirname, 'storage/app/public')));

// Set up file storage disk
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    const dir = path.join(__dirname, 'storage/app/public/uploads');
    fs.mkdirSync(dir, { recursive: true });
    cb(null, dir);
  },
  filename: function (req, file, cb) {
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
    const ext = path.extname(file.originalname);
    cb(null, 'file-' + uniqueSuffix + ext);
  }
});

const upload = multer({
  storage: storage,
  limits: { fileSize: 10 * 1024 * 1024 } // 10MB
});

// In-Memory Database Store
let adminUser = {
  email: 'admin@starkink.co.id',
  password: 'admin123',
  name: 'Administrator STARKINK'
};

let formSettings = {
  title: 'FORM INVENTARIS JARINGAN PARTNER KALIMANTAN',
  code_prefix: 'INV-KAL',
  max_clients_per_antenna: 25
};

let formFields = [
  { id: 1, label: 'Nama Instansi / Lokasi', name: 'instance_name', type: 'text', section: 'Informasi Lokasi', is_required: true, is_active: true, sort_order: 1 },
  { id: 2, label: 'Alamat Lengkap', name: 'address', type: 'textarea', section: 'Informasi Lokasi', is_required: true, is_active: true, sort_order: 2 },
  { id: 3, label: 'Kabupaten / Kota', name: 'regency', type: 'dropdown', section: 'Informasi Lokasi', is_required: true, is_active: true, sort_order: 3, options: ['Balikpapan', 'Samarinda', 'Bontang', 'Kutai Kartanegara', 'Kutai Timur', 'Banjarmasin', 'Banjarbaru', 'Palangka Raya', 'Pontianak', 'Tanjung Selor'] },
  { id: 4, label: 'Provinsi', name: 'province', type: 'dropdown', section: 'Informasi Lokasi', is_required: true, is_active: true, sort_order: 4, options: ['Kalimantan Timur', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Barat', 'Kalimantan Utara'] },
  { id: 5, label: 'Nama PIC / Pengisi', name: 'pic_name', type: 'text', section: 'Informasi Lokasi', is_required: true, is_active: true, sort_order: 5 },
  { id: 6, label: 'Nomor HP / WhatsApp', name: 'pic_phone', type: 'text', section: 'Informasi Lokasi', is_required: true, is_active: true, sort_order: 6 },
  { id: 7, label: 'Jarak (km)', name: 'distance_km', type: 'number', section: 'Jarak & Akses', is_required: true, is_active: true, sort_order: 7 },
  { id: 8, label: 'Jenis Topologi', name: 'topology_type', type: 'dropdown', section: 'Topologi Jaringan', is_required: true, is_active: true, sort_order: 8, options: ['Star (Bintang)', 'Tree (Pohon)', 'Mesh (Jaring)', 'Point to Point (PTP)', 'Point to Multipoint (PTMP)', 'Lainnya'] }
];

let responses = [
  {
    id: 1,
    response_code: 'INV-KAL-2026-00001',
    instance_name: 'PT Kalimantan Coal Resources - Site Samboja',
    address: 'Jl. Poros Balikpapan-Samarinda KM 45, Samboja, Kutai Kartanegara',
    regency: 'Kutai Kartanegara',
    province: 'Kalimantan Timur',
    pic_name: 'Budi Santoso',
    pic_position: 'Senior IT Field Specialist',
    pic_phone: '081255566778',
    pic_email: 'budi.santoso@kcr-mining.co.id',
    distance_km: 48.5,
    access_mode: 'Darat (Jalan Aspal)',
    road_condition: 'Bagus / Aspal Mulus',
    vehicle_type: 'Mobil Double Cabin 4WD',
    travel_time: '1 Jam 15 Menit',
    latitude: -1.023456,
    longitude: 116.987654,
    topology_type: 'Star (Bintang)',
    topology_description: 'Distribusi sinyal Starlink disalurkan via router MikroTik ke switch PoE Ruijie.',
    total_devices: 9,
    total_antennas: 2,
    total_clients: 41,
    devices: [
      { type: 'Modem / ONT', brand: 'Starlink', model: 'Standard Actuated', quantity: 1, specs: 'Dish Gen 2 + Router V2', condition: 'Baik' },
      { type: 'Router', brand: 'MikroTik', model: 'RB5009UG+S+IN', quantity: 1, specs: '7x GbE, 1x 2.5G, 1x SFP+', condition: 'Baik' },
      { type: 'Switch', brand: 'Ruijie', model: 'RG-ES218GC-P', quantity: 2, specs: '16-Port GbE Smart PoE Switch', condition: 'Baik' },
      { type: 'Access Point (AP)', brand: 'Ruijie Reyee', model: 'RG-RAP2260(E)', quantity: 4, specs: 'Wi-Fi 6 AX3200 Indoor AP', condition: 'Baik' },
      { type: 'UPS / Power', brand: 'ICA', model: 'SE2000 2000VA', quantity: 1, specs: 'Online UPS 2000VA / 1800W', condition: 'Baik' }
    ],
    antennas: [
      { code: 'Antena Main Basecamp', brand_model: 'Ruijie Outdoor Sector', frequency: '5 GHz', install_location: 'Tower Monopole 15m', client_count: 22, max_clients: 25 },
      { code: 'Antena Mess Karyawan', brand_model: 'Ubiquiti LiteAP AC', frequency: '5 GHz', install_location: 'Atap Gedung Mess 1', client_count: 19, max_clients: 25 }
    ],
    status: 'submitted',
    submitted_at: '2026-10-04 14:30:00'
  },
  {
    id: 2,
    response_code: 'INV-KAL-2026-00002',
    instance_name: 'Klinik Medika Sehat - Muara Teweh',
    address: 'Jl. Jendral Sudirman No. 88, Muara Teweh, Barito Utara',
    regency: 'Barito Utara',
    province: 'Kalimantan Tengah',
    pic_name: 'Ahmad Riza',
    pic_position: 'Kepala Unit IT',
    pic_phone: '082199887766',
    pic_email: 'riza@medikasehat.or.id',
    distance_km: 120.0,
    access_mode: 'Kombinasi Darat & Sungai',
    road_condition: 'Rusak / Tanah Berlumpur',
    vehicle_type: 'Mobil SUV 4WD & Perahu Klotok',
    travel_time: '4 Jam 30 Menit',
    latitude: -0.954321,
    longitude: 114.890123,
    topology_type: 'Point to Multipoint (PTMP)',
    topology_description: 'Starlink HP Enterprise terkoneksi ke CCR2004 lalu dipancarkan ke 3 sektor antena.',
    total_devices: 5,
    total_antennas: 3,
    total_clients: 61,
    devices: [
      { type: 'Modem / ONT', brand: 'Starlink High Performance', model: 'Flat HP', quantity: 1, specs: 'Enterprise Starlink Kit', condition: 'Baik' },
      { type: 'Router', brand: 'MikroTik', model: 'CCR2004-16G-2S+', quantity: 1, specs: '16x GbE ports', condition: 'Baik' },
      { type: 'Access Point (AP)', brand: 'Ubiquiti', model: 'U6-Pro', quantity: 3, specs: 'Wi-Fi 6 AP', condition: 'Baik' }
    ],
    antennas: [
      { code: 'Antena PTMP Sektor Utara', brand_model: 'Ubiquiti Rocket Prism 5AC', frequency: '5.8 GHz', install_location: 'Tiang Galvanis 12m', client_count: 24, max_clients: 25 },
      { code: 'Antena PTMP Sektor Selatan', brand_model: 'Ubiquiti Rocket Prism 5AC', frequency: '5.8 GHz', install_location: 'Tiang Galvanis 12m', client_count: 25, max_clients: 25 },
      { code: 'Antena PTMP Sektor Timur', brand_model: 'Ubiquiti LiteAP AC', frequency: '5.8 GHz', install_location: 'Atap Gedung Utama', client_count: 12, max_clients: 25 }
    ],
    status: 'submitted',
    submitted_at: '2026-10-04 16:15:00'
  }
];

let responseCounter = 3;

// Active Auth Cookie Mock
let loggedInAdmins = new Set();

function isAuth(req) {
  return loggedInAdmins.has('admin_session');
}

// User Public Form Route
app.get('/', (req, res) => res.redirect('/form'));
app.get('/form', (req, res) => {
  res.sendFile(path.join(__dirname, 'resources/views/user/form.blade.php'));
});

// User Form Submit Route
app.post('/form', upload.fields([
  { name: 'topology_file', maxCount: 1 },
  { name: 'foto_lokasi', maxCount: 1 },
  { name: 'foto_perangkat', maxCount: 1 },
  { name: 'foto_antena', maxCount: 1 },
  { name: 'foto_instalasi', maxCount: 1 }
]), (req, res) => {
  const body = req.body;
  const numStr = String(responseCounter).padStart(5, '0');
  const code = `${formSettings.code_prefix}-2026-${numStr}`;
  responseCounter++;

  // Process devices
  let devicesList = [];
  let totalDevs = 0;
  if (body.devices) {
    const devArr = Array.isArray(body.devices) ? body.devices : Object.values(body.devices);
    devArr.forEach(d => {
      if (d.device_type) {
        const q = parseInt(d.quantity) || 1;
        totalDevs += q;
        devicesList.push({
          type: d.device_type,
          brand: d.brand || '-',
          model: d.model || '-',
          quantity: q,
          specs: d.specs || '-',
          condition: d.condition || 'Baik'
        });
      }
    });
  }

  // Process antennas
  let antennasList = [];
  let totalAnts = 0;
  let totalClis = 0;
  if (body.antennas) {
    const antArr = Array.isArray(body.antennas) ? body.antennas : Object.values(body.antennas);
    antArr.forEach((a, idx) => {
      totalAnts++;
      const cli = parseInt(a.client_count) || 0;
      totalClis += cli;
      antennasList.push({
        code: a.antenna_code || `Antena ${idx+1}`,
        brand_model: a.brand_model || '-',
        frequency: a.frequency || '-',
        install_location: a.install_location || '-',
        client_count: cli,
        max_clients: formSettings.max_clients_per_antenna
      });
    });
  }

  const newRes = {
    id: responses.length + 1,
    response_code: code,
    instance_name: body.instance_name || 'Lokasi Partner',
    address: body.address || '-',
    regency: body.regency || 'Balikpapan',
    province: body.province || 'Kalimantan Timur',
    pic_name: body.pic_name || '-',
    pic_position: body.pic_position || '-',
    pic_phone: body.pic_phone || '-',
    pic_email: body.pic_email || '-',
    distance_km: parseFloat(body.distance_km) || 0,
    access_mode: body.access_mode || 'Darat',
    road_condition: body.road_condition || 'Bagus',
    vehicle_type: body.vehicle_type || 'Mobil 4WD',
    travel_time: body.travel_time || '-',
    latitude: parseFloat(body.latitude) || -1.234,
    longitude: parseFloat(body.longitude) || 116.890,
    topology_type: body.topology_type || 'Star',
    topology_description: body.topology_description || '-',
    total_devices: totalDevs,
    total_antennas: totalAnts,
    total_clients: totalClis,
    devices: devicesList,
    antennas: antennasList,
    status: 'submitted',
    submitted_at: new Date().toISOString().replace('T', ' ').substring(0, 19)
  };

  responses.unshift(newRes);
  res.redirect(`/form/success/${code}`);
});

// Confirmation Success Route
app.get('/form/success/:code', (req, res) => {
  const code = req.params.code;
  const item = responses.find(r => r.response_code === code);
  if (!item) return res.status(404).send('Response not found');

  let html = fs.readFileSync(path.join(__dirname, 'resources/views/user/success.blade.php'), 'utf8');
  html = html.replace('{{ $response->response_code }}', item.response_code);
  html = html.replace('{{ $response->location_name }}', item.instance_name);
  html = html.replace('{{ $response->regency }}', item.regency);
  html = html.replace('{{ $response->province }}', item.province);
  html = html.replace('{{ $response->pic_name }}', item.pic_name);
  html = html.replace('{{ $response->pic_phone }}', item.pic_phone);
  html = html.replace('{{ $response->total_devices }}', item.total_devices);
  html = html.replace('{{ $response->total_antennas }}', item.total_antennas);
  html = html.replace('{{ $response->total_clients }}', item.total_clients);
  html = html.replace("{{ $response->submitted_at ? $response->submitted_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }}", item.submitted_at);

  res.send(html);
});

// Admin Auth Routes
app.get('/admin/login', (req, res) => {
  res.sendFile(path.join(__dirname, 'resources/views/auth/login.blade.php'));
});

app.post('/admin/login', (req, res) => {
  const { email, password } = req.body;
  if (email === adminUser.email && password === adminUser.password) {
    loggedInAdmins.add('admin_session');
    res.setHeader('Set-Cookie', 'admin_session=1; Path=/');
    res.redirect('/admin/dashboard');
  } else {
    res.redirect('/admin/login?error=invalid');
  }
});

app.post('/admin/logout', (req, res) => {
  loggedInAdmins.delete('admin_session');
  res.redirect('/admin/login');
});

// Admin Dashboard Route
app.get('/admin/dashboard', (req, res) => {
  res.sendFile(path.join(__dirname, 'resources/views/admin/dashboard.blade.php'));
});

// Admin Responses Index Route
app.get('/admin/responses', (req, res) => {
  res.sendFile(path.join(__dirname, 'resources/views/admin/responses/index.blade.php'));
});

// Admin Responses Detail Route
app.get('/admin/responses/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const item = responses.find(r => r.id === id || r.response_code === req.params.id);
  if (!item) return res.status(404).send('Response record not found');
  res.sendFile(path.join(__dirname, 'resources/views/admin/responses/show.blade.php'));
});

// Export CSV Route
app.get('/admin/export/csv', (req, res) => {
  res.setHeader('Content-Type', 'text/csv; charset=UTF-8');
  res.setHeader('Content-Disposition', 'attachment; filename="starkink_inventory_export.csv"');
  
  let csv = '\uFEFFKode Respon,Nama Lokasi,Kabupaten,Provinsi,PIC,Nomor HP,Total Antena,Total Client,Total Perangkat,Tanggal\n';
  responses.forEach(r => {
    csv += `"${r.response_code}","${r.instance_name}","${r.regency}","${r.province}","${r.pic_name}","${r.pic_phone}",${r.total_antennas},${r.total_clients},${r.total_devices},"${r.submitted_at}"\n`;
  });
  res.send(csv);
});

// Export Excel Route
app.get('/admin/export/excel', (req, res) => {
  res.setHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
  res.setHeader('Content-Disposition', 'attachment; filename="starkink_inventory_export.xls"');
  
  let html = `<html><head><meta charset="UTF-8"></head><body><table border="1">
    <tr style="background:#0F172A;color:#FFF;"><th>Kode Respon</th><th>Nama Lokasi</th><th>Kabupaten</th><th>Provinsi</th><th>PIC</th><th>No HP</th><th>Antena</th><th>Client</th><th>Perangkat</th><th>Tanggal</th></tr>`;
  responses.forEach(r => {
    html += `<tr><td>${r.response_code}</td><td>${r.instance_name}</td><td>${r.regency}</td><td>${r.province}</td><td>${r.pic_name}</td><td>${r.pic_phone}</td><td>${r.total_antennas}</td><td>${r.total_clients}</td><td>${r.total_devices}</td><td>${r.submitted_at}</td></tr>`;
  });
  html += `</table></body></html>`;
  res.send(html);
});

// PDF Print Route
app.get('/admin/responses/:id/pdf', (req, res) => {
  res.sendFile(path.join(__dirname, 'resources/views/admin/responses/pdf.blade.php'));
});

// Form Builder Route
app.get('/admin/form-builder', (req, res) => {
  res.sendFile(path.join(__dirname, 'resources/views/admin/form-builder/index.blade.php'));
});

app.listen(PORT, () => {
  console.log(`STARKINK Kalimantan Inventory App running on http://localhost:${PORT}`);
});
