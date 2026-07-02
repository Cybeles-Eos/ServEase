<?php
/**
*
*   Create Global Function
*/

function custom_flash($title = null, $message = null) {
    // Set variable $flash to fetch the Flash Class
    // in Flash.php
    $flash = app('App\Http\Flash');

    // If 0 parameters are passed in ($title, $message)
    // then just return the flash instance.
    if (func_num_args() == 0) {
        return $flash;
    }

    // Just return a regular flash->info message
    return $flash->info($title, $message);
}

function services(){
    $services = \App\Models\Service::with('serviceCategory')->visibleToCustomers()->latest()->get();
    return $services;
}

function getActiveServiceCategories()
{
    return \App\Models\ServiceCategory::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get();
}

function getPlatformSettings()
{
    return \App\Models\PlatformSetting::current();
}

function platformAssetUrl(?string $storedPath, string $fallback): string
{
    if (empty($storedPath)) {
        return asset($fallback);
    }

    if (str_starts_with($storedPath, 'http://') || str_starts_with($storedPath, 'https://')) {
        return $storedPath;
    }

    return asset('storage/' . ltrim($storedPath, '/'));
}

function platformFrontLogoUrl(): string
{
    return platformAssetUrl(getPlatformSettings()->front_logo_path, 'images/new-logo-d.png');
}

function platformFrontFooterLogoUrl(): string
{
    return platformAssetUrl(getPlatformSettings()->front_footer_logo_path, 'images/new-logo-l.png');
}

function platformFaviconUrl(): string
{
    return platformAssetUrl(getPlatformSettings()->front_favicon_path, 'images/icons/favicon.svg');
}

function platformMetaImageUrl(): string
{
    return platformAssetUrl(getPlatformSettings()->meta_image_path, 'images/meta-cover.png');
}
