# update-symfony.ps1 : https://github.com/dunglas/symfony-docker/blob/main/docs/updating.md
Write-Host "1. Fetching updates..." -ForegroundColor Green
git fetch upstream

Write-Host "`n2. Checking differences..." -ForegroundColor Green
git diff upstream/main compose.yaml
git diff upstream/main Dockerfile
git diff upstream/main frankenphp/

Write-Host "`n3. Updating Symfony dependencies..." -ForegroundColor Green
docker compose exec php composer update "symfony/*" --with-all-dependencies

Write-Host "`n4. Rebuilding containers..." -ForegroundColor Green
docker compose down
docker compose build --no-cache
docker compose up -d

Write-Host "`nUpdate complete!" -ForegroundColor Green