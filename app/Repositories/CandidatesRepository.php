<?php

namespace App\Repositories;

use App\Models\Candidate;
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
            ->get(['name'])
            ->map(function ($candidate) {
                return trim(
                    join(' ', [
                        htmlspecialchars(data_get($candidate, 'name')),
                    ])
                );
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();
    }

    public static function search(array $data, array $columns = null): Collection
    {
        $query = Candidate::query();

        if ($search = data_get($data, 'search')) {
            $array = explode(' ', $search);

            if (count($array) === 2) {
                $query = $query
                    ->where('name', 'like', '%'.$array[0].'%');
            } else {
                $query = $query
                    ->where(function (Builder $query) use ($array) {
                        $query
                            ->where(function (Builder $query) use ($array) {
                                foreach ($array as $item) {
                                    $query->orWhere('name', 'like', "%{$item}%");
                                }
                            });
                    });
            }
        }

        if ($recruitment = data_get($data, 'recruitment')) {
            $query = $query->where('recruitment_id', $recruitment);
        }

        if (!empty($columns)) {
            $query->select($columns);
        } else {
            $query->with('recruitment');
        }

        return $query->get();
    }
}
