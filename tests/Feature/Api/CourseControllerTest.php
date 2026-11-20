<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_courses_as_a_json_resource_collection(): void
    {
        Course::create([
            'name' => 'Web Development',
            'description' => 'An introductory course.',
            'duration' => 8,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => true,
        ]);

        $this->getJson('/api/courses')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'description',
                    'duration',
                    'fee',
                    'difficulty',
                    'is_active',
                ]],
            ])
            ->assertJsonPath('data.0.name', 'Web Development')
            ->assertJsonPath('data.0.fee', '450.00');
    }

    public function test_store_creates_a_course_and_returns_201_with_a_resource(): void
    {
        $this->postJson('/api/courses', [
            'name' => 'Web Development',
            'description' => 'An introductory course.',
            'duration' => 8,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => true,
        ])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Web Development')
            ->assertJsonPath('data.is_active', true);

        $this->assertDatabaseHas('courses', [
            'name' => 'Web Development',
            'fee' => '450.00',
            'is_active' => true,
        ]);
    }

    public function test_store_returns_422_for_invalid_course_data(): void
    {
        $this->postJson('/api/courses', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'duration', 'fee', 'difficulty', 'is_active']);

        $this->assertDatabaseCount('courses', 0);
    }

    public function test_show_returns_the_requested_course_resource(): void
    {
        $course = Course::create([
            'name' => 'Web Development',
            'description' => 'An introductory course.',
            'duration' => 8,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => true,
        ]);

        $this->getJson("/api/courses/{$course->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $course->id)
            ->assertJsonPath('data.difficulty', 'Medium');
    }

    public function test_update_changes_a_course_and_returns_its_resource(): void
    {
        $course = Course::create([
            'name' => 'Web Development',
            'description' => 'An introductory course.',
            'duration' => 8,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => true,
        ]);

        $this->putJson("/api/courses/{$course->id}", [
            'name' => 'Advanced Web Development',
            'description' => 'An advanced course.',
            'duration' => 12,
            'fee' => '650.00',
            'difficulty' => 'Hard',
            'is_active' => false,
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Advanced Web Development')
            ->assertJsonPath('data.is_active', false);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Advanced Web Development',
            'is_active' => false,
        ]);
    }

    public function test_update_returns_422_for_invalid_course_data(): void
    {
        $course = Course::create([
            'name' => 'Web Development',
            'duration' => 8,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => true,
        ]);

        $this->putJson("/api/courses/{$course->id}", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'duration', 'fee', 'difficulty', 'is_active']);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Web Development',
        ]);
    }

    public function test_destroy_deletes_a_course_and_returns_204(): void
    {
        $course = Course::create([
            'name' => 'Web Development',
            'duration' => 8,
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => true,
        ]);

        $this->deleteJson("/api/courses/{$course->id}")->assertNoContent();

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_missing_course_returns_404(): void
    {
        $this->getJson('/api/courses/9999')->assertNotFound();
    }
}
