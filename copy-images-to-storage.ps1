# Script copy anh vao storage/app/public/images
Write-Host "=== Script copy anh vao storage/app/public/images ===" -ForegroundColor Green

$destDir = "storage\app\public\images"

# Tao thu muc neu chua co
if (-not (Test-Path $destDir)) {
    New-Item -ItemType Directory -Force -Path $destDir | Out-Null
    Write-Host "Da tao thu muc: $destDir" -ForegroundColor Yellow
}

# Danh sach thu muc co the chua anh
$sourceDirs = @(
    "public\images",
    "public\images1", 
    "public\images2",
    "public\assets\images"
)

$totalCopied = 0
$totalSkipped = 0

foreach ($sourceDir in $sourceDirs) {
    if (Test-Path $sourceDir) {
        Write-Host "`nDang tim anh trong: $sourceDir" -ForegroundColor Cyan
        $images = Get-ChildItem $sourceDir -File -Include *.jpg,*.png,*.jpeg,*.gif -ErrorAction SilentlyContinue
        
        if ($images) {
            foreach ($img in $images) {
                $destFile = Join-Path $destDir $img.Name
                if (-not (Test-Path $destFile)) {
                    Copy-Item $img.FullName -Destination $destFile -Force
                    $totalCopied++
                    Write-Host "  [OK] Da copy: $($img.Name)" -ForegroundColor Green
                } else {
                    $totalSkipped++
                    Write-Host "  [SKIP] Da ton tai: $($img.Name)" -ForegroundColor Gray
                }
            }
        } else {
            Write-Host "  Khong tim thay file anh" -ForegroundColor Gray
        }
    } else {
        Write-Host "`nThu muc khong ton tai: $sourceDir" -ForegroundColor Red
    }
}

Write-Host "`n=== KET QUA ===" -ForegroundColor Green
Write-Host "Tong so file da copy: $totalCopied" -ForegroundColor Yellow
Write-Host "Tong so file da bo qua: $totalSkipped" -ForegroundColor Gray
Write-Host "`nThu muc dich: $destDir" -ForegroundColor Cyan

# Kiem tra lai
$finalFiles = Get-ChildItem $destDir -File
Write-Host "Tong so file trong thu muc dich: $($finalFiles.Count)" -ForegroundColor Green
