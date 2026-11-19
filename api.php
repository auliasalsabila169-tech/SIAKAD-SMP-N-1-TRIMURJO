mkdir api -Force
Set-Content -Path "api\index.php" -Value "<?php`nrequire __DIR__ . '/../public/index.php';"
Remove-Item "index.php" -ErrorAction SilentlyContinue