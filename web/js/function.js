//共通関数化の範囲ここから---//
var x;
var y;
var outputStr;
function skill_date(x,y){
  // 開始日と現在の時間差を計算
  const diffMilliSec=y-x;//終了日-開始日のミリ秒差
  /*return diffMilliSec;*/
/*if(diffMilliSec<=0){
document.getElementById('diff').textContent = '日付を正しく入力してください。';
}else{*/
  // 年の数値を計算
  const year = Math.floor(diffMilliSec / 1000 / 60 / 60 / 24 / 30 / 12);
  // 月の数値を計算
  const month = Math.floor(diffMilliSec / 1000 / 60 / 60 / 24 / 30) % 12;
  /*return year,month;*/
  // 文字列を格納するための変数
  let outputStr = "";
  // 年のテキストを生成(0の場合は表示しない)
  if (year !== 0) {
    outputStr += `${year}年`;
  }
  // 月のテキストを生成(0の場合は表示しない)
  if (month !== 0) {
    outputStr += `${month}ヶ月`;
  }
  // 年と月が両方0のとき、"1ヶ月未満"を表示
  if (year == 0 && month == 0) {
    outputStr += "1ヶ月未満";
  }
  /*差の日数をHTMLに表示*/
  return outputStr;

}
//共通関数化の範囲ここまで---//
  /*差の日数をHTMLに表示*/
  //document.getElementById('diff').textContent = outputStr;
//console.log(x,y);
//console.log(skill_date(x,y));
