export default {
  getDayName (dayIndex) {
    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    return days[dayIndex];
  },
  
  getDate (year, month){
    const startDate = new Date(year, month - 1, 1);
    const endDate   = new Date(year, month, 0)    ;
    const dates     = []                          ;
    const result    = []                          ;
  
    // Menambahkan tanggal sebelumnya jika tanggal satu bukan hari Senin
    while (startDate.getDay() !== 1) {
      startDate.setDate(startDate.getDate() - 1);
    }
  
    // Menambahkan tanggal-tanggal dari awal bulan sampai akhir bulan
    for (let date = startDate; date <= endDate; date.setDate(date.getDate() + 1)) {
      const dayOfWeek = date.getDay();
  
      // Skip tanggal hari Sabtu dan Minggu
      if (dayOfWeek === 0 || dayOfWeek === 6) {
        continue;
      }
  
      const tanggal = date.getDate    (         )    ;
      const hari    = this.getDayName (dayOfWeek)    ;
      const bulan   = date.getMonth   (         ) + 1;
      const tahun   = date.getFullYear(         )    ;
  
      const dateObject = {
        hari : hari,
        tgl  : tanggal,
        bulan: bulan,
        tahun: tahun,
        data : []
      };
  
      dates.push(dateObject);
    }
  
    // Membagi data menjadi array per 5 hari
    for (let i = 0; i < dates.length; i += 5) {
      result.push(dates.slice(i, i + 5));
    }
  
    return result;
  }
}