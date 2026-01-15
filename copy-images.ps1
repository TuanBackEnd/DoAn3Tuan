# Script copy anh vao storage/app/public/images
$sourceDirs = @("public\images", "public\assets\images", "public\images1", "public\images2")
$destDir = "storage\app\public\images"

# Tao thu muc neu chua co
if (-not (Test-Path $destDir)) {
    New-Item -ItemType Directory -Force -Path $destDir | Out-Null
    Write-Host "Da tao thu muc: $destDir"
}

$totalCopied = 0
foreach ($sourceDir in $sourceDirs) {
    if (Test-Path $sourceDir) {
        Write-Host "`nDang tim anh trong: $sourceDir"
        $images = Get-ChildItem $sourceDir -File -Include *.jpg,*.png,*.jpeg,*.gif -ErrorAction SilentlyContinue
        foreach ($img in $images) {
            $destFile = Join-Path $destDir $img.Name
            if (-not (Test-Path $destFile)) {
                Copy-Item $img.FullName -Destination $destFile -Force
                $totalCopied++
                Write-Host "  âœ“ Da copy: $($img.Name)"
            } else {
                Write-Host "  - Da ton tai: $($img.Name)"
            }
        }
    }
}

Write-Host "`n=== Hoan thanh ==="
Write-Host "Tong so file da copy: $totalCopied"
