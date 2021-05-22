<?php

use App\Constants\StatusType;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Quote\Quote;
use App\FMS\Site\Models\Site;

/**
 * @return string
 */
function getCopyrightYearFormatted(): string
{
    $startYear   = config('config.copyright.start_year');
    $currentYear = date('Y');

    return $currentYear > $startYear ? sprintf("%s - %s", $startYear, $currentYear) : sprintf("%s", $startYear);
}

/**
 * Get the user details for the delete button.
 * @param $user
 * @return array
 */
function getUserDetailsForDeleteButton($user): array
{
    if ($user->status === StatusType::DEACTIVATED) {
        return [
            'change_action'   => 'activate',
            'title'           => 'Activate User',
            'icon'            => 'fa fa-check',
            'success_message' => 'Successfully activated user.',
        ];
    } else {
        return [
            'change_action'   => 'deactivate',
            'title'           => 'Deactivate User',
            'icon'            => 'fa fa-trash',
            'success_message' => 'Successfully deactivated user.',
        ];
    }
}

/**
 * Get the module details for the delete button.
 * @param $user
 * @return array
 */
function getModuleDetailsForDeleteButton(): array
{
        return [
            'change_action'   => 'deactivate',
            'title'           => 'Delete Module',
            'icon'            => 'fa fa-trash',
            'success_message' => 'Successfully Deleted Module.',
        ];
}

/**
 * Check if the submenu of tenant is active or not, checking the URI.
 * @param string $subMenu
 * @return string
 */
function getSubMenuClassName(string $subMenu): string
{
    return (request()->routeIs($subMenu)) ? 'm-menu__item--active' : '';
}

/**
 * Check if the menu is active or not, checking the URI.
 * @param $menuParams
 * @return string
 */
function getSideBarClassName($menuParams): string
{
    $urlParams = explode('/', url()->current());
    if (is_array($menuParams)) {
        foreach ($menuParams as $menu) {
            if (in_array($menu, $urlParams)) {
                return 'm-menu__item--active';
            }
        }

        return '';
    } else {
        return in_array($menuParams, $urlParams) ? 'm-menu__item--active' : '';
    }
}

/**
 * Returns the words for a slug.
 *
 * @param string $slug
 * @return string
 */
function deSlugify(string $slug)
{
    return ucwords(strtolower(preg_replace('/[_-]/', ' ', $slug)));

}

function getQuoteCode($siteId)
    {
        $site = app(Site::class)->where('id', $siteId)->first();
        $quotes = Quote::where('site_id', $siteId)->get();
        $quoteIds = $quotes->pluck('quote_id');
        $hasNumberInQuote = $quoteIds->contains(function ($value, $key) use($site) {
            return $value >= $site->quote_number_from && $value <= $site->quote_number_to;
        });
        
        $jobs = Job::where('site_id', $siteId)->get();
        $jobIds = $jobs->pluck('job_id');
        $hasNumberInJob = $jobs->pluck('job_id')->contains(function ($value, $key) use($site) {
            return $value >= $site->quote_number_from && $value <= $site->quote_number_to;
        });

        if (!$hasNumberInJob && !$hasNumberInQuote) {
            return $site->quote_number_from;
        } else {
            $allQuotes = $quoteIds->merge($jobIds)->sort();
            for($i = $site->quote_number_from; $i<=$site->quote_number_to; $i++) {
                if (!$allQuotes->contains($i)) {
                    return $i;
                }
            }
        }
    }
