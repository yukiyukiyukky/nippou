function convertToSeireki() {
  const gengo = document.getElementById("gengo_select").value.toUpperCase();
  const nen = parseInt(document.getElementById("nen").value);
  const month = parseInt(document.getElementById("month").value);
  const day = parseInt(document.getElementById("day").value);

  if (!gengo || !nen || !month || !day) {
    return;
  }

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
    // alert("和暦の年号が正しくありません。");
    return;
  }

  const seirekiMonth = month;
  const seirekiDay = day;
  const seirekiDate = new Date(seirekiYear, seirekiMonth - 1, seirekiDay);
  const seireki = seirekiDate.getFullYear() + "年" + (seirekiDate.getMonth() + 1) + "月" + seirekiDate.getDate() + "日";
  document.getElementById("seireki").textContent = seireki;
}
