try {
    $r = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/books/1/view-pdf' -Method Head -TimeoutSec 10
    Write-Output "Status: $($r.StatusCode)"
    Write-Output "Content-Type: $($r.Headers.'Content-Type')"
    Write-Output "Content-Disposition: $($r.Headers.'Content-Disposition')"
    Write-Output "Accept-Ranges: $($r.Headers.'Accept-Ranges')"
    Write-Output "Content-Length: $($r.Headers.'Content-Length')"
} catch {
    Write-Output "Error: $($_.Exception.Message)"
    if ($_.Exception.Response) {
        Write-Output "StatusCode: $($_.Exception.Response.StatusCode.value__)"
    }
}
