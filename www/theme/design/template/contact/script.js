/* contact의 js 파일 입니다. */
/*
const txtWrap = document.querySelector('.typing');
const txtString = '호치킨은 홀치킨 ! \n 독보적인 메뉴들로 차별화된 홀 경쟁력, 호치킨이 성공을 약속합니다.';
const txtSpeed = 100;
const txtDelay = 1000;
let txtIndex = 0;
let typeCotrol = true;

function typingEvent(){
  if(typeCotrol === true){
    let txtNow = txtString[txtIndex++];
    txtWrap.innerHTML += txtNow === "\n" ? "<br>": txtNow;
    console.log(txtIndex)
    if(txtIndex >= txtString.length){
      txtIndex = 0;
      typeCotrol = false;
    }
  }else{
    clearInterval(setTyping);
    setTimeout(function(){
      txtWrap.innerHTML = '';
      typeCotrol = true;
      setTyping = setInterval(typingEvent, txtSpeed);
    }, txtDelay)
  }

}

let setTyping = setInterval(typingEvent, txtSpeed);
*/