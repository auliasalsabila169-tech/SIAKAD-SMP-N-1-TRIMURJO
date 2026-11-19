mkdir api -Force
'<?php require __DIR__ . "/../public/index.php";' | Out-File -FilePath "api\index.php" -Encoding utf8
git add .
git commit -m "Add api/index.php"
git push origin main