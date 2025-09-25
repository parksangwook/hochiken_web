<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>호치킨 세트메이커</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Noto Sans KR',sans-serif;overscroll-behavior:none}
    .image-container{position:relative;width:100%}
    .box-piece-top-left{position:absolute;top:25%;left:25%;transform:translate(-49%,-48.5%) scale(.94);width:50%;height:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .box-piece-top-center{position:absolute;top:25%;left:50%;transform:translate(-50%,-50%) rotate(180deg) scale(.94);width:50%;height:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .box-piece-top-right{position:absolute;top:25%;left:75%;transform:translate(-51%,-48.5%) scale(.94);width:50%;height:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .box-piece-bottom-left{position:absolute;top:75%;left:25%;transform:translate(-49%,-52%) rotate(180deg) scale(.94);width:50%;height:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .box-piece-bottom-center{position:absolute;top:75%;left:50%;transform:translate(-50%,-50%) scale(.94);width:50%;height:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .box-piece-bottom-right{position:absolute;top:75%;left:75%;transform:translate(-51%,-52%) rotate(180deg) scale(.94);width:50%;height:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .diamond-piece{position:absolute;visibility:hidden}
    .diamond-0-1{top:25%;left:37.5%;width:75%;height:50%;transform:translate(-49.5%,-49%) scale(.94);clip-path:polygon(25% 0%,100% 0,75% 100%,0% 100%)}
    .diamond-1-2{top:25%;left:62.5%;width:75%;height:50%;transform:translate(-51%,-49%) scale(.94) rotate(60deg);clip-path:polygon(25% 0%,100% 0,75% 100%,0% 100%)}
    .diamond-2-3{top:50%;left:75%;width:75%;height:50%;transform:translate(-51%,-50%) scale(.94) rotate(120deg);clip-path:polygon(25% 0%,100% 0,75% 100%,0% 100%)}
    .diamond-3-4{top:75.5%;left:62.5%;width:75%;height:50%;transform:translate(-50.5%,-52%) scale(.94);clip-path:polygon(25% 0%,100% 0,75% 100%,0% 100%)}
    .diamond-4-5{top:75.5%;left:37.5%;width:75%;height:50%;transform:translate(-49.5%,-52%) scale(.94) rotate(60deg);clip-path:polygon(25% 0%,100% 0,75% 100%,0% 100%)}
    .diamond-0-5{top:50%;left:25%;width:75%;height:50%;transform:translate(-49%,-50%) scale(.94) rotate(-60deg);clip-path:polygon(25% 0%,100% 0,75% 100%,0% 100%)}
    .menu-item-img{cursor:move;touch-action:none}
    .highlight-piece{position:absolute;pointer-events:none;opacity:0;transition:opacity .2s ease-in-out;width:50%;clip-path:polygon(50% 0%,100% 100%,0% 100%)}
    .highlight-piece-top-left{top:25.5%;left:25.3%;transform:translate(-50%,-49.5%) scale(.96)}
    .highlight-piece-top-center{top:25.5%;left:50%;transform:translate(-50%,-49.5%) rotate(180deg) scale(.96)}
    .highlight-piece-top-right{top:25.5%;left:74.7%;transform:translate(-50%,-49.5%) scale(.96)}
    .highlight-piece-bottom-right{top:74.5%;left:74.7%;transform:translate(-50%,-50.5%) rotate(180deg) scale(.96)}
    .highlight-piece-bottom-center{top:74.5%;left:50%;transform:translate(-50%,-50.5%) scale(.96)}
    .highlight-piece-bottom-left{top:74.5%;left:25.3%;transform:translate(-50%,-50.5%) rotate(180deg) scale(.96)}
    .dragging-ghost{position:fixed;pointer-events:none;z-index:9999;opacity:.75;transform:translate(-50%,-50%)}
    /* 메뉴 섹션 */
    #menu-gallery{background-image:url('./images/menu_bg.png');background-size:100% 100%;background-repeat:no-repeat;background-position:center}
    .menu-tab{cursor:pointer;background-size:100% 100%;background-repeat:no-repeat;background-position:center}
    #chicken-tab:not(.active){background-image:url('./images/03_menu_tap_chic_off.png')}
    #chicken-tab.active{background-image:url('./images/03_menu_tap_chic_on.png')}
    #side-tab:not(.active){background-image:url('./images/03_menu_tap_side_off.png')}
    #side-tab.active{background-image:url('./images/03_menu_tap_side_on.png')}
    /* 제출 폼 정렬 개선 */
    .form-wrap label{letter-spacing:-.2px}
    .input-like{height:44px}
    @media (min-width:640px){.input-like{height:48px}}
  </style>
</head>
<body class="bg-[#0e390c] flex justify-center">
  <div class="w-full max-w-[720px] bg-[#2e6b2c] text-white">
    
    <img src="./images/session1.png" alt="호치킨 세트메이커 이벤트" class="w-full align-top" />

    <div class="relative">
      <img src="./images/session2.png" alt="세트메이커 참여 방법" class="w-full align-top" />
      <img src="./images/session2_desc.png" alt="참여 방법 설명" class="absolute top-[0%] w-full" />
    </div>

    <div id="menu-maker-section" class="relative">
      <img src="./images/session3.png" alt="직접 만들기" class="w-full align-top" />
      <img src="./images/03_title.png" alt="직접 만들기 타이틀" class="absolute top-[-1.3%] w-[100%]" />

      <div class="absolute top-[49%] left-1/2 -translate-x-1/2 -translate-y-1/2 w-[77%]">
        <div class="image-container" id="drop-container">
          <img src="./images/box_white.png" alt="box_white" class="center-image w-full" />
          <img src="./images/box_piece.png" alt="box_piece" class="box-piece box-piece-top-left" data-slot="0" />
          <img src="./images/box_piece.png" alt="box_piece" class="box-piece box-piece-top-center" data-slot="1" />
          <img src="./images/box_piece.png" alt="box_piece" class="box-piece box-piece-top-right" data-slot="2" />
          <img src="./images/box_piece.png" alt="box_piece" class="box-piece box-piece-bottom-right" data-slot="3" />
          <img src="./images/box_piece.png" alt="box_piece" class="box-piece box-piece-bottom-center" data-slot="4" />
          <img src="./images/box_piece.png" alt="box_piece" class="box-piece box-piece-bottom-left" data-slot="5" />

          <img src="" alt="diamond_piece" class="diamond-piece diamond-0-1" data-pair="0-1" />
          <img src="" alt="diamond_piece" class="diamond-piece diamond-1-2" data-pair="1-2" />
          <img src="" alt="diamond_piece" class="diamond-piece diamond-2-3" data-pair="2-3" />
          <img src="" alt="diamond_piece" class="diamond-piece diamond-3-4" data-pair="3-4" />
          <img src="" alt="diamond_piece" class="diamond-piece diamond-4-5" data-pair="4-5" />
          <img src="" alt="diamond_piece" class="diamond-piece diamond-0-5" data-pair="0-5" />

          <img id="highlight-0" src="./images/box_piece_y.png" alt="highlight" class="highlight-piece highlight-piece-top-left" />
          <img id="highlight-1" src="./images/box_piece_y.png" alt="highlight" class="highlight-piece highlight-piece-top-center" />
          <img id="highlight-2" src="./images/box_piece_y.png" alt="highlight" class="highlight-piece highlight-piece-top-right" />
          <img id="highlight-3" src="./images/box_piece_y.png" alt="highlight" class="highlight-piece highlight-piece-bottom-right" />
          <img id="highlight-4" src="./images/box_piece_y.png" alt="highlight" class="highlight-piece highlight-piece-bottom-center" />
          <img id="highlight-5" src="./images/box_piece_y.png" alt="highlight" class="highlight-piece highlight-piece-bottom-left" />
        </div>
      </div>

      <img id="pepsi-can" src="./images/03_pepsi_before.png" alt="펩시 포함" class="absolute top-[68.5%] right-[8%] w-[15%] -translate-y-1/2 cursor-pointer transition-transform active:scale-95" />

      <img id="confirm-menu-btn" src="./images/03_bt.png" alt="메뉴 확정 버튼" class="absolute bottom-[2%] w-full cursor-pointer transition-transform active:scale-95 drop-shadow-2xl" />
    </div>

    <div class="relative">
      <img src="./images/session4.png" alt="메뉴 확장" class="w-full align-top" />
      <div class="absolute top-[5.8%] bottom-[18.4%] left-[8%] right-[6.4%]">
        <div id="menu-container" class="w-full h-full flex flex-col">
          <div class="flex w-full h-[9%]">
            <div id="chicken-tab" class="menu-tab w-[50%] h-full active"></div>
            <div id="side-tab" class="menu-tab w-[50%] h-full"></div>
          </div>
          <div id="menu-gallery" class="w-full h-[91%] grid grid-cols-3 grid-rows-3 p-3"></div>
        </div>
      </div>
    </div>

    <img src="./images/session5.png" alt="이벤트 경품" class="w-full align-top" />

   
   
   
 <div id="submission-section" class="relative">
  <img src="./images/session6.png" alt="제출하기" class="w-full align-top" />

  <div class="absolute top-0 left-0 w-full h-full">
    <form id="event-form" class="w-full h-full flex flex-col">

      <div class="relative h-[13%] flex-shrink-0">
        <img src="./images/05_title.png" alt="제출하기 타이틀" class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-35%] w-[85%]" />
      </div>

      <div class="relative h-[62%] w-[90%] mx-auto min-h-0 flex-shrink-0 py-2">
        <div class="h-full flex flex-col gap-y-2">
          
          <div class="grid grid-cols-5 gap-x-4 sm:gap-x-6">
            <div class="col-span-2">
              <label for="user_name" class="block mb-1.5 text-xs sm:text-sm font-medium">성함 <span class="text-yellow-400">*</span></label>
              <input type="text" id="user_name" name="user_name" class="w-full bg-[#102414] border-none rounded-md p-2 h-9 text-white text-xs sm:text-sm" required />
            </div>
            <div class="col-span-3">
              <label for="user_contact" class="block mb-1.5 text-xs sm:text-sm font-medium">연락처 <span class="text-yellow-400">*</span></label>
              <input type="tel" inputmode="numeric" id="user_contact" name="user_contact" class="w-full bg-[#102414] border-none rounded-md p-2 h-9 text-white text-xs sm:text-sm" placeholder="'-' 없이 숫자만 입력" required />
            </div>
          </div>
          
          <div>
            <label for="set_name" class="block mb-1.5 text-xs sm:text-sm font-medium">내가 만든 세트 이름 <span class="text-yellow-400">*</span></label>
            <input type="text" id="set_name" name="set_name" class="w-full bg-[#102414] border-none rounded-md p-2.5 h-9 text-white text-xs sm:text-sm" required />
          </div>
          
          <div class="flex flex-col flex-grow min-h-0">
            <label for="set_description" class="block mb-1.5 text-xs sm:text-sm font-medium flex-shrink-0">세트 설명</label>
            <textarea id="set_description" name="set_description" class="w-full bg-[#102414] border-none rounded-md p-2.5 text-white text-xs sm:text-sm resize-none flex-grow"></textarea>
          </div>
          
          <div class="mt-1">
            <label class="block mb-1.5 text-xs sm:text-sm font-medium">개인정보 제공 동의 항목 <span class="text-yellow-400">*</span></label>
            <div id="privacy-policy-content" class="w-full h-20 overflow-y-auto bg-[#102414] border-none rounded-md p-2.5 text-white text-xs whitespace-pre-line">
            </div>
            <div class="mt-2 flex items-center">
              <input id="agree_privacy" name="agree_privacy" type="checkbox" value="yes" class="w-4 h-4 rounded accent-yellow-400 bg-gray-700 border-gray-600">
              <label for="agree_privacy" class="ml-2 text-xs sm:text-sm font-medium">개인정보 제공 내용에 동의합니다.</label>
            </div>
          </div>
        </div>
      </div>
      
      <div class="relative h-[25%] flex-shrink-0">
        <button type="submit" class="absolute top-[1%] left-1/2 w-full -translate-x-1/2 transition-transform active:scale-95">
          <img src="./images/05_bt.png" alt="이벤트 참여하기" />
        </button>
        <button id="share-btn" type="button" class="absolute top-[40%] left-1/2 w-[61%] -translate-x-1/2 cursor-pointer transition-transform active:scale-95">
          <img src="./images/05_share_link.png" alt="링크 복사하기" />
        </button>
      </div>
      
    </form>
  </div>
</div>




  <div id="confirmation-modal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[9999]">
    <div class="bg-white text-gray-800 rounded-xl shadow-2xl p-6 sm:p-8 w-11/12 max-w-sm text-center">
      <p id="confirmation-text" class="text-lg font-bold mb-6">메뉴를 교체하시겠습니까?</p>
      <div class="flex justify-center gap-x-4">
        <button id="cancel-overwrite" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">취소</button>
        <button id="confirm-overwrite" class="w-full px-4 py-2 bg-yellow-400 text-green-900 rounded-lg font-semibold hover:bg-yellow-500 transition-colors">확인</button>
      </div>
    </div>
  </div>

  <div id="success-modal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[9999]">
    <div class="bg-white text-gray-800 rounded-xl shadow-2xl p-8 w-11/12 max-w-sm text-center">
      <h2 class="text-2xl font-bold mb-4 text-[#2e6b2c]">🎉 참여 완료!</h2>
      <p class="text-lg mb-8">이벤트 참여가 성공적으로 완료되었습니다.</p>
      <button id="close-success-modal" class="w-full px-4 py-3 bg-yellow-400 text-black rounded-lg font-semibold hover:bg-yellow-500 transition-colors shadow-lg">
        확인
      </button>
    </div>
  </div>

  <div id="alert-modal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[10000]">
    <div class="bg-white text-gray-800 rounded-xl shadow-2xl p-6 sm:p-8 w-11/12 max-w-sm text-center">
      <p id="alert-text" class="text-lg font-bold mb-8"></p>
      <div class="flex justify-center">
        <button id="close-alert-modal" class="w-full px-4 py-2 bg-yellow-400 text-green-900 rounded-lg font-semibold hover:bg-yellow-500 transition-colors">확인</button>
      </div>
    </div>
  </div>


 <script>
document.addEventListener('DOMContentLoaded', () => {
  const menuData = {
            'chicken': [
                { name: '크리스피순살', src: './images/product/menu_1-1.png', size: 1 }, 
                { name: '양념순살', src: './images/product/menu_1-2.png', size: 1 },
                { name: '간장순살', src: './images/product/menu_1-3.png', size: 1 }, 
                { name: '치즈찐', src: './images/product/menu_1-4.png', size: 1 },
                { name: '맛나게맵닭', src: './images/product/menu_1-5.png', size: 1 }, 
                { name: '치타치킨', src: './images/product/menu_1-6.png', size: 1 },
                { name: '고추똥집튀김', src: './images/product/menu_1-7.png', size: 1 }, 
                { name: '페퍼스넥', src: './images/product/menu_1-8.png', size: 1 },
                { name: '크런치윙봉', src: './images/product/menu_1-9.png', size: 1 },
            ],
            'side': [
                { name: '스푼떡볶이', src: './images/product/menu_2-1.png', size: 2 }, 
                { name: '누들로제떡볶이', src: './images/product/menu_2-2.png', size: 2 },
                { name: '매콤비빔쫄면', src: './images/product/menu_2-3.png', size: 2 }, 
                { name: '라구스파게티', src: './images/product/menu_2-4.png', size: 2 },
                { name: '케이준후라이', src: './images/product/menu_3-1.png', size: 1 }, 
                { name: '스노윙후라이', src: './images/product/menu_3-2.png', size: 1 },
                { name: '치타후라이', src: './images/product/menu_3-3.png', size: 1 }, 
                { name: '치즈볼', src: './images/product/menu_3-4.png', size: 1 },
                { name: '탱글새우튀김', src: './images/product/menu_3-5.png', size: 1 },
            ]
        };

  // =======================================================
  // ✨ 개인정보 약관 파일 로드 기능 추가 ✨
  // =======================================================
  function loadPrivacyPolicy() {
    const policyContainer = document.getElementById('privacy-policy-content');
    if (policyContainer) {
      fetch('privacy_policy.txt')
        .then(response => {
          if (!response.ok) {
            throw new Error('Privacy policy file not found.');
          }
          return response.text();
        })
        .then(text => {
          policyContainer.textContent = text;
        })
        .catch(error => {
          console.error('Error loading privacy policy:', error);
          policyContainer.textContent = '개인정보 제공 동의 항목을 불러오는 데 실패했습니다. 관리자에게 문의해주세요.';
        });
    }
  }

  function preloadImages(data) {
    const imageUrls = [];
    for (const category in data) {
      data[category].forEach(item => {
        imageUrls.push(item.src);
        const placedSrc = item.src.replace('.png', '_p.png').replace('.jpg', '_p.jpg');
        imageUrls.push(placedSrc);
      });
    }
    imageUrls.forEach(url => { const img = new Image(); img.src = url; });
    console.log(`🚀 ${imageUrls.length}개의 이미지를 프리로딩했습니다.`);
  }

  const menuGallery = document.getElementById('menu-gallery');
  const tabs = document.querySelectorAll('.menu-tab');
  const highlightPieces = document.querySelectorAll('.highlight-piece');
  const dropContainer = document.getElementById('drop-container');
  const confirmationModal = document.getElementById('confirmation-modal');
  const confirmOverwriteBtn = document.getElementById('confirm-overwrite');
  const cancelOverwriteBtn = document.getElementById('cancel-overwrite');

  let slotContents = {};
  let ghostElement = null;
  let draggedElement = null, draggedMenuName = null, draggedOriginalSrc = null, draggedCategory = null, highlightedPair = [], draggedItemSize = null;
  let pendingDropAction = null;

  function executePlacement(menuName, originalSrc, size, targetSlots) {
    if (size === '2' && targetSlots && targetSlots.length === 2) {
      clearSlot(targetSlots[0]);
      clearSlot(targetSlots[1]);
      const piece1 = document.querySelector(`[data-slot="${targetSlots[0]}"]`);
      const piece2 = document.querySelector(`[data-slot="${targetSlots[1]}"]`);
      if (piece1) piece1.style.visibility = 'hidden';
      if (piece2) piece2.style.visibility = 'hidden';
      const diamondPairKey = [...targetSlots].sort().join('-');
      const diamondPiece = document.querySelector(`[data-pair="${diamondPairKey}"]`);
      if (diamondPiece) {
        const newSrc = originalSrc.replace('.png', '_p.png').replace('.jpg', '_p.jpg');
        diamondPiece.src = newSrc;
        diamondPiece.style.visibility = 'visible';
      }
      slotContents[targetSlots[0]] = { name: menuName, pair: diamondPairKey };
      slotContents[targetSlots[1]] = { name: menuName, pair: diamondPairKey };
    }
    else if (size === '1' && targetSlots && targetSlots.length === 1) {
      const slot = targetSlots[0];
      if (slot === null) return;
      clearSlot(slot);
      const actualTargetPiece = document.querySelector(`[data-slot="${slot}"]`);
      const newSrc = originalSrc.replace('.png', '_p.png').replace('.jpg', '_p.jpg');
      actualTargetPiece.src = newSrc;
      slotContents[slot] = { name: menuName };
    }
    updateHighlights(null);
  }

  function handleDrop(menuName, originalSrc, category, size, clientX, clientY) {
    let targetSlots = [];
    if (size === '2' && highlightedPair.length === 2) {
      targetSlots = [...highlightedPair];
    } else if (size === '1') {
      let minDist = Infinity, closestSlot = null;
      for (let i = 0; i < 6; i++) {
        const slotIndex = String(i);
        const el = document.getElementById(`highlight-${slotIndex}`);
        if (!el) continue;
        const r = el.getBoundingClientRect();
        const cx = r.left + r.width / 2, cy = r.top + r.height / 2;
        const d = Math.hypot(clientX - cx, clientY - cy);
        if (d < r.width / 1.5 && d < minDist) { minDist = d; closestSlot = slotIndex; }
      }
      if (closestSlot) targetSlots.push(closestSlot);
    }
    
    if (targetSlots.length === 0) {
      updateHighlights(null);
      return;
    }

    const isOccupied = targetSlots.some(slot => slotContents[slot]);

    if (isOccupied) {
      pendingDropAction = { menuName, originalSrc, size, targetSlots };
      confirmationModal.classList.remove('hidden');
    } else {
      executePlacement(menuName, originalSrc, size, targetSlots);
    }
  }
  
    function clearSlot(slot){
      const content=slotContents[slot];
      if(!content) return;
      if(content.pair){
        const pairKey=content.pair;
        const diamondPiece=document.querySelector(`[data-pair="${pairKey}"]`);
        if(diamondPiece){diamondPiece.style.visibility='hidden';diamondPiece.src=''}
        const [slot1,slot2]=pairKey.split('-');
        const piece1=document.querySelector(`[data-slot="${slot1}"]`);
        if(piece1){piece1.src='./images/box_piece.png';piece1.style.visibility='visible'}
        const piece2=document.querySelector(`[data-slot="${slot2}"]`);
        if(piece2){piece2.src='./images/box_piece.png';piece2.style.visibility='visible'}
        delete slotContents[slot1];
        delete slotContents[slot2];
      }else{
        const piece=document.querySelector(`[data-slot="${slot}"]`);
        if(piece){piece.src='./images/box_piece.png'}
        delete slotContents[slot];
      }
    }
    function handleDragMove(clientX,clientY){
      const dropContainerRect=dropContainer.getBoundingClientRect();
      const isInside=(clientX>=dropContainerRect.left&&clientX<=dropContainerRect.right&&clientY>=dropContainerRect.top&&clientY<=dropContainerRect.bottom);
      if(!isInside){updateHighlights(null);return}
      if(draggedItemSize==='2'){
        const pairs=[["0","1"],["1","2"],["3","4"],["4","5"],["0","5"],["2","3"]];
        let minDist=Infinity,closestPair=null;
        for(const pair of pairs){
          const a=document.getElementById(`highlight-${pair[0]}`);
          const b=document.getElementById(`highlight-${pair[1]}`);
          if(!a||!b) continue;
          const ra=a.getBoundingClientRect();
          const rb=b.getBoundingClientRect();
          const cx=(ra.left+ra.right+rb.left+rb.right)/4;
          const cy=(ra.top+ra.bottom+rb.top+rb.bottom)/4;
          const d=Math.hypot(clientX-cx,clientY-cy);
          if(d<minDist){minDist=d;closestPair=pair}
        }
        if(closestPair) updateHighlights(closestPair);
      } else {
        let minDist=Infinity,closestSlot=null;
        for(let i=0;i<6;i++){
          const slotIndex=String(i);
          const el=document.getElementById(`highlight-${slotIndex}`);
          if(!el) continue;
          const r=el.getBoundingClientRect();
          const cx=r.left+r.width/2, cy=r.top+r.height/2;
          const d=Math.hypot(clientX-cx,clientY-cy);
          if(d<r.width/1.5 && d<minDist){minDist=d;closestSlot=slotIndex}
        }
        updateHighlights(closestSlot);
      }
    }
    function updateHighlights(slotsToHighlight){
      highlightedPair=[];
      const slots=Array.isArray(slotsToHighlight)?slotsToHighlight.map(String):(slotsToHighlight!==null?[String(slotsToHighlight)]:[]);
      if(Array.isArray(slotsToHighlight)) highlightedPair=slotsToHighlight;
      highlightPieces.forEach(el=>{const s=el.id.replace('highlight-','');el.style.opacity=slots.includes(s)?'1':'0'});
    }

    function showMessage(text){
      const alertModal = document.getElementById('alert-modal');
      const alertText = document.getElementById('alert-text');
      if (alertModal && alertText) {
        alertText.innerHTML = text;
        alertModal.classList.remove('hidden');
      }
    }

    function renderMenu(category){
      menuGallery.innerHTML='';
      menuData[category].forEach(item=>{
        const itemDiv=document.createElement('div');
        itemDiv.className='w-full h-full flex flex-col items-center justify-start overflow-hidden';
        const wrap=document.createElement('div');
        wrap.className='w-full h-[80%] flex items-center justify-center';
        const img=document.createElement('img');
        img.src=item.src;img.alt=item.name;img.className='w-full h-full object-contain menu-item-img';
        img.dataset.name=item.name;img.dataset.category=category;img.dataset.size=item.size;img.draggable=true;
        const text=document.createElement('div');
        text.className='w-full h-[20%] flex items-start justify-center';
        const span=document.createElement('span');
        span.className='text-[clamp(11px,1.9vw,14px)] text-center break-keep font-semibold -translate-y-[30%]';
        span.textContent=item.name;
        wrap.appendChild(img);text.appendChild(span);itemDiv.appendChild(wrap);itemDiv.appendChild(text);menuGallery.appendChild(itemDiv);
      })
    }
    tabs.forEach(tab=>{
      tab.addEventListener('click',()=>{tabs.forEach(t=>t.classList.remove('active'));tab.classList.add('active');renderMenu(tab.id.replace('-tab',''))})
    });
    dropContainer.addEventListener('click', e => {
      let minDist = Infinity, closestSlot = null;
      const x = e.clientX, y = e.clientY;
      for (let i = 0; i < 6; i++) {
          const idx = String(i);
          const hl = document.getElementById(`highlight-${idx}`);
          if (!hl) continue;
          const r = hl.getBoundingClientRect();
          if (x >= r.left && x <= r.right && y >= r.top && y <= r.bottom) {
              const cx = r.left + r.width / 2, cy = r.top + r.height / 2;
              const d = Math.hypot(x - cx, y - cy);
              if (d < minDist) { minDist = d; closestSlot = idx; }
          }
      }
      if (closestSlot && slotContents[closestSlot]) clearSlot(closestSlot);
  });
  document.addEventListener('dragstart', e => {
    if(e.target.classList.contains('menu-item-img')){
        draggedCategory=e.target.dataset.category;draggedItemSize=e.target.dataset.size;
        e.dataTransfer.setData('text/plain',e.target.dataset.name);
        e.dataTransfer.setData('original-src',e.target.src);
        e.dataTransfer.setData('category',draggedCategory);
        e.dataTransfer.setData('size',draggedItemSize);
    }
  });
  document.addEventListener('dragover', e => { e.preventDefault(); handleDragMove(e.clientX, e.clientY); });
  document.addEventListener('dragend', () => { updateHighlights(null); draggedCategory = null; draggedItemSize = null; });
  document.addEventListener('drop', e => {
      e.preventDefault();
      const name = e.dataTransfer.getData('text/plain');
      const src = e.dataTransfer.getData('original-src');
      const category = e.dataTransfer.getData('category');
      const size = e.dataTransfer.getData('size');
      if (name && src) {
        handleDrop(name, src, category, size, e.clientX, e.clientY);
      }
  });
  document.addEventListener('touchstart', e => {
      if (e.target.classList.contains('menu-item-img')) {
          e.preventDefault(); draggedElement = e.target; draggedMenuName = draggedElement.dataset.name; draggedOriginalSrc = draggedElement.src; draggedCategory = draggedElement.dataset.category; draggedItemSize = draggedElement.dataset.size;
          const touch = e.touches[0]; const rect = draggedElement.getBoundingClientRect();
          ghostElement = draggedElement.cloneNode(true); ghostElement.classList.add('dragging-ghost'); ghostElement.style.width = `${rect.width * 1.2}px`; ghostElement.style.height = `${rect.height * 1.2}px`;
          document.body.appendChild(ghostElement); ghostElement.style.left = `${touch.clientX}px`; ghostElement.style.top = `${touch.clientY}px`;
          handleDragMove(touch.clientX, touch.clientY);
      }
  }, { passive: false });
  document.addEventListener('touchmove', e => {
    if (draggedElement) { e.preventDefault(); const t = e.touches[0]; if (ghostElement) { ghostElement.style.left = `${t.clientX}px`; ghostElement.style.top = `${t.clientY}px`; } handleDragMove(t.clientX, t.clientY) }
  }, { passive: false });
  document.addEventListener('touchend', e => {
      if (draggedElement) {
          const t = e.changedTouches[0];
          handleDrop(draggedMenuName, draggedOriginalSrc, draggedCategory, draggedItemSize, t.clientX, t.clientY);
          if (ghostElement) { document.body.removeChild(ghostElement) }
      }
      draggedElement = null; ghostElement = null; draggedMenuName = null; draggedOriginalSrc = null; draggedCategory = null; draggedItemSize = null;
  });

  cancelOverwriteBtn.addEventListener('click', () => {
    confirmationModal.classList.add('hidden');
    pendingDropAction = null;
    updateHighlights(null);
  });
  confirmOverwriteBtn.addEventListener('click', () => {
    if (pendingDropAction) {
      executePlacement(
        pendingDropAction.menuName,
        pendingDropAction.originalSrc,
        pendingDropAction.size,
        pendingDropAction.targetSlots
      );
    }
    confirmationModal.classList.add('hidden');
    pendingDropAction = null;
  });
  
  function resetEventState() {
      Object.keys(slotContents).forEach(slot => {
          if (slotContents[slot]) {
              clearSlot(slot);
          }
      });
      document.getElementById('event-form').reset();
      
      const pepsiCan = document.getElementById('pepsi-can');
      const pepsiInput = document.querySelector('input[name="pepsi_included"]');
      if (pepsiCan) {
        pepsiCan.src = './images/03_pepsi_before.png';
      }
      if(pepsiInput){
        pepsiInput.value = "no";
      }
  }

  function areAllSlotsFilled() {
    return Object.keys(slotContents).length === 6;
  }

  document.getElementById('event-form').addEventListener('submit', e => {
      e.preventDefault(); 
      const form = e.target;
      const submitButton = form.querySelector('button[type="submit"]');
      const pepsiInput = form.querySelector('input[name="pepsi_included"]');

      if (!areAllSlotsFilled()) {
          showMessage('메뉴를 모두 채워주셔야<br>이벤트에 참여하실 수 있습니다');
          document.getElementById('menu-maker-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
          return;
      }
      if (pepsiInput && pepsiInput.value !== 'yes') {
          showMessage('펩시를 선택해야<br>이벤트에 참여하실 수 있습니다');
          document.getElementById('menu-maker-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
          return;
      }

      if (!form.user_name.value.trim()) { showMessage('성함을 입력해주세요.'); form.user_name.focus(); return; }
      if (!form.user_contact.value.trim()) { showMessage('연락처를 입력해주세요.'); form.user_contact.focus(); return; }
      
      const contactValue = form.user_contact.value;
      if (!/^[0-9]+$/.test(contactValue)) {
          showMessage('연락처는 숫자만 입력해주세요.');
          form.user_contact.focus();
          return;
      }

      if (!form.set_name.value.trim()) { showMessage('내가 만든 세트 이름을 입력해주세요.'); form.set_name.focus(); return; }
      
      // =======================================================
      // ✨ 개인정보 동의 여부 확인 로직 추가 ✨
      // =======================================================
      const privacyCheckbox = document.getElementById('agree_privacy');
      if (!privacyCheckbox.checked) {
          showMessage('개인정보 제공 내용에<br>동의해주셔야 합니다.');
          privacyCheckbox.focus();
          return;
      }

      for (let i = 0; i < 6; i++) {
          const hiddenInput = form.querySelector(`input[name="menu_${i + 1}"]`);
          if (hiddenInput) {
              hiddenInput.value = slotContents[String(i)] ? slotContents[String(i)].name : '';
          }
      }
      
      const formData = new FormData(form);
      submitButton.disabled = true;

      fetch('submit.php', {
          method: 'POST',
          body: formData
      })
      .then(response => {
          if (!response.ok) {
              throw new Error(`서버 응답 오류: ${response.statusText}`);
          }
          return response.json();
      })
      .then(data => {
          if (data.success) {
              document.getElementById('success-modal').classList.remove('hidden');
          } else {
              showMessage('오류: ' + (data.message || '알 수 없는 오류'));
          }
      })
      .catch(error => {
          console.error('Fetch Error:', error);
          showMessage('전송 중 오류가 발생했습니다.<br>잠시 후 다시 시도해주세요.');
      })
      .finally(() => {
          submitButton.disabled = false; 
      });
  });

  document.getElementById('close-success-modal').addEventListener('click', () => {
      document.getElementById('success-modal').classList.add('hidden');
      resetEventState();
  });

  document.getElementById('close-alert-modal').addEventListener('click', () => {
    document.getElementById('alert-modal').classList.add('hidden');
  });

  const confirmButton = document.getElementById('confirm-menu-btn');
  const submissionSection = document.getElementById('submission-section');
  if (confirmButton && submissionSection) {
      confirmButton.addEventListener('click', () => {
          const pepsiInput = document.querySelector('input[name="pepsi_included"]');
          
          if (!areAllSlotsFilled()) {
              showMessage('메뉴를 모두 채워주셔야<br>이벤트에 참여하실 수 있습니다');
              return;
          }
          if (pepsiInput && pepsiInput.value !== 'yes') {
              showMessage('펩시를 선택해야<br>이벤트에 참여하실 수 있습니다');
              return;
          }
          submissionSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
  }

  const pepsiCan = document.getElementById('pepsi-can');
  if (pepsiCan) {
      const beforeSrc = './images/03_pepsi_before.png';
      const afterSrc = './images/03_pepsi_after.png';
      const pepsiInput = document.querySelector('input[name="pepsi_included"]');

      const pepsiAfterImage = new Image();
      pepsiAfterImage.src = afterSrc;

      pepsiCan.addEventListener('click', () => {
          if (pepsiCan.src.includes('before')) {
              pepsiCan.src = afterSrc;
              if (pepsiInput) pepsiInput.value = "yes";
          } else {
              pepsiCan.src = beforeSrc;
              if (pepsiInput) pepsiInput.value = "no";
          }
      });
  }
  
  const shareBtn = document.getElementById('share-btn');
  if(shareBtn) {
    const eventUrl = "<?php require_once 'config.php'; echo $config['event_url']; ?>";
    
    function legacyCopy(text) {
      const textArea = document.createElement('textarea');
      textArea.value = text;
      textArea.style.position = 'fixed';
      textArea.style.left = '-9999px';
      document.body.appendChild(textArea);
      textArea.select();
      try {
        document.execCommand('copy');
        showMessage('이벤트 링크를 복사했습니다!');
      } catch (err) {
        console.error('Legacy copy failed', err);
        showMessage('링크 복사에 실패했습니다.<br>다시 시도해주세요.');
      }
      document.body.removeChild(textArea);
    }

    shareBtn.addEventListener('click', () => {
      if (navigator.share) {
        navigator.share({
          title: '호치킨 세트메이커 이벤트',
          text: '내가 만드는 메뉴 꿀 조합! 총 천만원 상금 획득의 기회!',
          url: eventUrl,
        }).catch((error) => {
          if (error.name !== 'AbortError') console.error('Share failed:', error);
        });
      } 
      else if (navigator.clipboard) {
        navigator.clipboard.writeText(eventUrl).then(() => {
          showMessage('이벤트 링크를 복사했습니다!');
        }).catch(err => {
          console.warn('Clipboard API failed, falling back to legacy.', err);
          legacyCopy(eventUrl); 
        });
      } 
      else {
        legacyCopy(eventUrl);
      }
    });
  }

  // 페이지 초기화 함수 호출
  loadPrivacyPolicy();
  preloadImages(menuData);
  renderMenu('chicken');
});
</script>
</body>
</html>