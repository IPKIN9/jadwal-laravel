import * as ExcelJS from 'exceljs';
import { saveAs } from 'file-saver'
import moment from 'moment';

export default {
  async orderLogs(jurusan, payload, period) {
    const date = moment().format("DD-MM-YYYY");
    const workbook = new ExcelJS.Workbook();

    /* Create worksheet */
    const columnHeaders = [
      { header: "Mata Pelajaran"   , key: "mapel"      },
      { header: "Pengajar"         , key: "guru"       },
      { header: "Jumlah Jam"       , key: "jumlah_jam" },
      { header: "Tanggal Mengajar" , key: "tgl"        },
      { header: "Jam Masuk"        , key: "jam_masuk"  },
      { header: "Jam Keluar"       , key: "jam_keluar" },
    ];

    for (const key in payload) {
      const worksheet = workbook.addWorksheet(`Report ${payload[key].nama_kelas}`);

      worksheet.getCell("A1").value = "Dibuat";
      worksheet.getCell("B1").value = date;
      worksheet.getCell("A2").value = "Periode";
      worksheet.getCell("B2").value = `${period.start} - ${period.end}`;
      worksheet.getCell("A3").value = "Kelas";
      worksheet.getCell("B3").value = payload[key].nama_kelas;

      worksheet.getRow(5).values = columnHeaders.map((column) => column.header);

      payload[key].data.forEach((item, index) => {
        const rowData = columnHeaders.map((column) => {
          let value = "";
          if (item.hasOwnProperty(column.key)) {
            if (["tgl"].includes(column.key)) {
              value = moment(item[column.key]).format("DD MMMM, YYYY")
            } else {
              value = item[column.key];
            }
          }
          return value;
        });
        worksheet.addRow(rowData, `A${index + 6}`);
      });

      worksheet.mergeCells("B2:C2");
      // Set column widths

      columnHeaders.forEach((column, index) => {
        const values = payload[key].data.map((item) =>
          (item[column.key] || "").toString()
        );
        const maxLength = Math.max(
          column.header.length,
          ...values.map((value) => value.length)
        );
        worksheet.getColumn(index + 1).width = maxLength + 2;
      });

      worksheet.eachRow({ includeEmpty: false }, (row) => {
        row.alignment = { horizontal: "left" };
      });
    }

    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], {
      type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    });
    saveAs(blob, `jadwal-jurusan-${jurusan}-date-${date}.xlsx`);
  },
}