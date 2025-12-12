<?php

namespace App\Rules;

use App\Models\Step;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueStepCategoryPerTimeline implements ValidationRule
{
    private int $timelineId;

    /**
     * Create a new rule instance.
     *
     * @param  int  $timelineId  The ID of the timeline being checked.
     * @return void
     */
    public function __construct(int $timelineId)
    {
        $this->timelineId = $timelineId;
    }

    /**
     * Validate the given attribute.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if a step with this category already exists in the given timeline
        $exists = Step::where('timeline_id', $this->timelineId)
            ->where('step_category_id', $value)
            ->exists();

        if ($exists) {
            $fail('The step category has already been used in this timeline.');
        }
    }
}
