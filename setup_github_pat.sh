et -euo pipefail

# ----- GitHub 사용자 정보 -----
GITHUB_USER="jungsuplee-hub"
GITHUB_EMAIL="jungsup2.lee@gmail.com"
: "${GITHUB_PAT:?환경변수 GITHUB_PAT 를 먼저 export 해주세요}"

# Git 사용자 기본 설정
git config --global user.name  "$GITHUB_USER"
git config --global user.email "$GITHUB_EMAIL"

# 자격 증명 영구 저장 (편의)
git config --global credential.helper store

# ~/.git-credentials 파일에 PAT 저장
CRED_FILE="$HOME/.git-credentials"
URL="https://$GITHUB_USER:$GITHUB_PAT@github.com"

if [ -f "$CRED_FILE" ] && grep -q "^https://$GITHUB_USER:.*@github\.com" "$CRED_FILE"; then
  sed -i "s#^https://$GITHUB_USER:.*@github\.com#$URL#g" "$CRED_FILE"
else
  echo "$URL" >> "$CRED_FILE"
fi

chmod 600 "$CRED_FILE"

echo "[OK] GitHub PAT 설정 완료"
echo "저장소 연결 예시:"
echo "  git clone https://github.com/$GITHUB_USER/todayhouseprice.git"

