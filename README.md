# dosirakstore
written by Jeagang Lee. This code is work in "XpressEngine"(CMS tool like Wordpress)

안녕하세요. 오픈소스 CMS인 XE(XpressEngine)을 기반으로 제작한 도시락제국 사이트에서
도시락집 목록과 네이버 지도를 표시하기 위해 제작한 모듈입니다.

- 간단한 기능소개
 - 반응형 디자인으로 모바일/PC 지원
 - 시/도와 구 단위로 주소 분류
 - 업체 리스트 + 주소를 네이버 지도에 출력
 - 리스트 내 번호는 모바일에선 전화버튼으로 보여주도록 함
 - 업체 추가 시 지도 클릭으로 추가하도록 만들었습니다.

- 사용법
 1. skins/default/List.html 파일 3번째 줄에 적힌 NAVER_MAP_API 부분에 네이버지도 API를 발급받아 입력해주세요.
(추가 : 네이버지도 2.0을 사용했던 작년과 달리, 2016년 9월 현재 3.0을 사용하고 있습니다.
        2.0 주소로도 동작하지만 새로운 기능을 이용하시려면 지도API 페이지 업그레이드 메뉴얼대로 수정이 필요합니다.)
 2. XE 설치폴더 내의 module/ 폴더에 dosirakstore 폴더를 넣고 관리자 페이지에서 업데이트 버튼을 눌러주시면 됩니다.
 
