<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/**
 * Class EmployeeDailyReport
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $username
 * @property string $report_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $tasks_completed
 * @property string|null $issues_faced
 * @property string|null $work_location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read int $minutes_worked
 * @property-read string $summary
 */
class EmployeeDailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'report_date',
        'start_time',
        'end_time',
        'tasks_completed',
        'issues_faced',
        'work_location',
    ];

    /**
     * Automatically fill user_id and username when creating
     */
    protected static function booted()
    {
        static::creating(function ($report) {
            if (auth()->check()) {
                $report->user_id = auth()->id();
                $report->username = auth()->user()->name;
            }
        });
    }

    /**
     * Get minutes worked between start and end time
     */
    public function getMinutesWorkedAttribute()
    {
        if ($this->start_time && $this->end_time) {
            try {
                $startFormat = (strlen($this->start_time) === 5) ? 'H:i' : 'H:i:s';
                $endFormat = (strlen($this->end_time) === 5) ? 'H:i' : 'H:i:s';

                $start = \Carbon\Carbon::createFromFormat($startFormat, $this->start_time);
                $end = \Carbon\Carbon::createFromFormat($endFormat, $this->end_time);

                return $end->diffInMinutes($start);
            } catch (\Exception $e) {
                return 0;
            }
        }

        return 0;
    }


    /**
     * Get a summary text of the report
     */
    public function getSummaryAttribute()
    {
        $date = $this->report_date ? Carbon::parse($this->report_date)->format('d M Y') : 'No Date';
        $minutes = $this->minutes_worked;
        $tasks = $this->tasks_completed ? substr($this->tasks_completed, 0, 50) . '...' : 'No Tasks Listed';

        return "Report for {$date} by {$this->username}: Worked {$minutes} minutes. Tasks: {$tasks}";
    }

    /**
     * Relationship to user (can be null if user deleted)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'report_date' => 'date',
    ];
}
