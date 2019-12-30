<?php

namespace App\Repositories;

use App\Candidate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CandidatesRepository
{
    public static function getOtherApplications(Candidate $candidate)
    {
        return Candidate::where('id', '!=', $candidate->id)
            ->where(function ($query) use ($candidate) {
                $query->where('email', '=', $candidate->email)
                    ->orWhere('email', '=', sha1($candidate->email))
                    ->orWhere('phone_number', '=', $candidate->phone_number)
                    ->orWhere('phone_number', '=', sha1($candidate->phone_number));
            })
            ->with('recruitment')
            ->get();
    }

    public static function getTypeaheadCandidatesNameCollection()
    {
        return Candidate::query()
            ->get(['first_name', 'last_name'])
            ->map(function ($candidate) {
                return trim(
                    join(' ', [
                        htmlspecialchars(data_get($candidate, 'first_name')),
                        htmlspecialchars(data_get($candidate, 'last_name')),
                    ])
                );
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();
    }

    public static function search(array $data): Collection
    {
        $query = Candidate::query();
        $query->with('recruitment');

        if ($search = data_get($data, 'search')) {
            $array = explode(' ', $search);

            if (count($array) === 2) {
                $query = $query
                    ->where('first_name', 'like', $array[0] . '%')
                    ->where('last_name', 'like', $array[1] . '%');
            } else {
                $query = $query
                    ->where(function (Builder $query) use ($array) {
                        $query
                            ->where(function (Builder $query) use ($array) {
                                foreach ($array as $item) {
                                    $query->orWhere('first_name', 'like', "$item%");
                                }
                            })
                            ->orWhere(function ($query) use ($array) {
                                foreach ($array as $item) {
                                    $query->orWhere('last_name', 'like', "$item%");
                                }
                            });
                    });
            }
        }

        if ($recruitment = data_get($data, 'recruitment')) {
            $query = $query->where('recruitment_id', $recruitment);
        }

        return $query->get();
    }
}
