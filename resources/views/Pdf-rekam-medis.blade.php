<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekam Medis - Print Template</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      padding: 0;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
    }

    .table th,
    .table td {
      padding: 8px;
      border: 1px solid #ddd;
      text-align: left;
    }

    .table th {
      background-color: #f8f9fa;
    }

    .table-striped tbody tr:nth-child(odd) {
      background-color: #f2f2f2;
    }

    .table-responsive {
      overflow-x: auto;
    }

    .d-flex {
      display: flex;
    }

    .justify-content-between {
      justify-content: space-between;
    }

    .justify-content-start {
      justify-content: flex-start;
    }

    .justify-content-md-end {
      justify-content: flex-end;
    }

    .btn {
      padding: 8px 16px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 4px;
      text-decoration: none;
    }

    .btn-primary {
      background-color: #007bff;
      color: white;
      border: none;
    }

    .btn-success {
      background-color: #28a745;
      color: white;
      border: none;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
      border: none;
    }

    .text-center {
      text-align: center;
    }

    .italic {
      font-style: italic;
    }

    .mb-2 {
      margin-bottom: 16px;
    }

    .mb-4 {
      margin-bottom: 32px;
    }

    .fs-5 {
      font-size: 1.25rem;
    }

    .text-uppercase {
      text-transform: uppercase;
    }
  </style>
</head>

<body>
  <div style="text-align: center">
    <h4 style="margin-bottom: 0">Klinik Mandiri THB</h4>
    <small>Jln. Raya Kaliabang Tengah No.2, Kec. Medan Satria, Bekasi, 17125</small>
  </div>

  <hr style="margin-bottom: 25px">

  <div style="margin-bottom: 20px">
    <table>
      <tbody>
        <tr>
          <td style="padding-right: 25px">
            <table>
              <tbody>
                <tr>
                  <td colspan="3">
                    <small><strong><u>Informasi Rekam</u></strong></small>
                  </td>
                </tr>
                <tr>
                  <td><small>Nomor Rekam</small></td>
                  <td><small>:</small></td>
                  <td><small>{{ $data['record_num'] }}</small></td>
                </tr>
                <tr>
                  <td><small>Dibuat</small></td>
                  <td><small>:</small></td>
                  <td><small>{{ $data['created_at'] }}</small></td>
                </tr>
                <tr>
                  <td><small>Catatan</small></td>
                  <td><small>:</small></td>
                  <td><small>{{ $data['desc'] }}</small></td>
                </tr>
              </tbody>
            </table>
          </td>

          <td>
            <table>
              <tbody>
                <tr>
                  <td colspan="3">
                    <strong><u><small>Pasien</small></u></strong>
                  </td>
                </tr>
                <tr>
                  <td><small>Nama</small></td>
                  <td><small>:</small></td>
                  <td><small>{{ $data['patient_name'] }}</small></td>
                </tr>
                <tr>
                  <td><small>Gender</small></td>
                  <td><small>:</small></td>
                  <td><small>{{ $data['patient']['gender'] }}</small></td>
                </tr>
                <tr>
                  <td><small>Gol. Darah</small></td>
                  <td><small>:</small></td>
                  <td><small>{{ $data['patient']['blood_type'] }}</small></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div>
    <small><strong><u>Daftar Riwayat</u></strong></small>
  </div>
  <div style="margin-bottom: 30px">
    <table class="table table-striped">
      <thead>
        <tr>
          <th><small>#</small></th>
          <th><small>Tanggal</small></th>
          <th><small>Keluhan</small></th>
          <th><small>Diagnosa</small></th>
          <th><small>Obat</small></th>
          <th><small>Saran/Masukan</small></th>
          <th><small>PIC</small></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($data['record_detail'] as $index => $rc)
        <tr>
          <th><small>{{ $index+1 }}</small></th>
          <td><small>{{ $rc['created_at'] }}</small></td>
          <td><small>{{ $rc['complaint'] }}</small></td>
          <td><small>{{ $rc['diagnosis'] }}</small></td>
          <td><small>{{ $rc['drag'] }}</small></td>
          <td><small>{{ $rc['suggestion'] }}</small></td>
          <td><small>{{ $rc['created_by'] }}</small></td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align: center"><small><i>Belum ada riawayat terdaftar!</i></small></td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <table>
    <tr>
      <td style="padding-bottom: 90px"><small>{{ $paraf_title }}</small></td>
    </tr>
    <tr>
      <td><small>{{ $docter }}</small></td>
    </tr>
  </table>
</body>

</html>