function convertToSeireki(warekiId, seirekiId) {
    const warekiStr = document.getElementById(warekiId).value;
  
    const regex = /^([MTSHRmtshr])(\d{1,2})\/(\d{1,2})\/(\d{1,2})$/;
    const matches = regex.exec(warekiStr);
    if (!matches) {
      alert("和暦の形式が正しくありません。（例：S55/7/20）");
      return;
    }
  
    const gengo = matches[1].toUpperCase();
    const nen = parseInt(matches[2]);
    const month = parseInt(matches[3]);
    const day = parseInt(matches[4]);
  
    let seirekiYear;
    if (gengo === "M") {
      seirekiYear = nen + 1867;
    } else if (gengo === "T") {
      seirekiYear = nen + 1911;
    } else if (gengo === "S") {
      seirekiYear = nen + 1925;
    } else if (gengo === "H") {
      seirekiYear = nen + 1988;
    } else if (gengo === "R") {
      seirekiYear = nen + 2018;
    } else {
      alert("和暦の年号が正しくありません。");
      return;
    }
  
    const seirekiMonth = month;
    const seirekiDay = day;
    const seirekiDate = new Date(seirekiYear, seirekiMonth - 1, seirekiDay);
    const seireki = seirekiDate.getFullYear() + "年" + (seirekiDate.getMonth() + 1) + "月" + seirekiDate.getDate() + "日";
    document.getElementById(seirekiId).textContent = seireki;
  }
