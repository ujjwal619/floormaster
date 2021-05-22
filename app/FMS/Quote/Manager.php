<?php

namespace App\FMS\Quote;

use App\Data\Entities\Models\Quote\Quote;
use App\FMS\User\Models\User;

class Manager
{
    public function findLatest(User $user)
    {
        return $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->join('tbl_quotes', 'tbl_quotes.site_id', 'sites.id')
            ->where('user_sites.user_id', $user->id)
            ->where('tbl_quotes.converted_to_job', 0)
            ->select(
                'tbl_quotes.id as id'
            )
            ->orderBy('tbl_quotes.updated_at', 'DESC')
            ->first();
    }

    public function update(Quote $quote, array $details)
    {
        return $quote->fill(['gst_inclusive_quote' => $details['gst_inclusive_quote']])->save();
    }

    public function findPrevious(User $user, int $jobId)
    {
        return $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->join('tbl_quotes', 'tbl_quotes.site_id', 'sites.id')
            ->where('user_sites.user_id', $user->id)
            ->where('tbl_quotes.id', '<', $jobId)
            ->where('tbl_quotes.converted_to_job', false)
            ->select(
                'tbl_quotes.id as id'
            )
            ->max('tbl_quotes.id');
    }

    public function findNext(User $user, int $jobId)
    {
        return $user->newQuery()
            ->join('user_sites', 'user_sites.user_id', 'auth_users.id')
            ->join('sites', 'sites.id', 'user_sites.site_id')
            ->join('tbl_quotes', 'tbl_quotes.site_id', 'sites.id')
            ->where('user_sites.user_id', $user->id)
            ->where('tbl_quotes.id', '>', $jobId)
            ->where('tbl_quotes.converted_to_job', false)
            ->select(
                'tbl_quotes.id as id'
            )
            ->min('tbl_quotes.id');
    }
}
