<?php

namespace Tests\Feature\Api;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_students_as_a_json_resource_collection(): void
    {
        Student::create([
            'name' => 'Taylor Student',
            'email' => 'taylor@example.com',
            'phone' => '555-0100',
            'address' => 'Main Street',
            'date_of_birth' => '2000-01-02',
        ]);

        $this->getJson('/api/students')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'email',
                    'phone',
                    'address',
                    'date_of_birth',
                    'age',
                ]],
            ])
            ->assertJsonPath('data.0.name', 'Taylor Student')
            ->assertJsonPath('data.0.date_of_birth', '2000-01-02');
    }

    public function test_store_creates_a_student_and_returns_201_with_a_resource(): void
    {
        $this->postJson('/api/students', [
            'name' => 'Taylor Student',
            'email' => 'taylor@example.com',
            'phone' => '555-0100',
            'address' => 'Main Street',
            'date_of_birth' => '2000-01-02',
        ])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Taylor Student')
            ->assertJsonPath('data.date_of_birth', '2000-01-02');

        $this->assertDatabaseHas('students', [
            'email' => 'taylor@example.com',
            'name' => 'Taylor Student',
        ]);
    }

    public function test_store_returns_422_for_invalid_student_data(): void
    {
        $this->postJson('/api/students', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone']);

        $this->assertDatabaseCount('students', 0);
    }

    public function test_store_returns_422_when_the_email_is_already_used(): void
    {
        Student::create([
            'name' => 'Existing Student',
            'email' => 'existing@example.com',
            'phone' => '555-0100',
        ]);

        $this->postJson('/api/students', [
            'name' => 'New Student',
            'email' => 'existing@example.com',
            'phone' => '555-0101',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseCount('students', 1);
    }

    public function test_show_returns_the_requested_student_resource(): void
    {
        $student = Student::create([
            'name' => 'Taylor Student',
            'email' => 'taylor@example.com',
            'phone' => '555-0100',
        ]);

        $this->getJson("/api/students/{$student->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $student->id)
            ->assertJsonPath('data.email', 'taylor@example.com');
    }

    public function test_update_changes_a_student_and_allows_its_existing_email(): void
    {
        $student = Student::create([
            'name' => 'Taylor Student',
            'email' => 'taylor@example.com',
            'phone' => '555-0100',
        ]);

        $this->putJson("/api/students/{$student->id}", [
            'name' => 'Taylor Updated',
            'email' => 'taylor@example.com',
            'phone' => '555-0102',
            'address' => 'New Street',
            'date_of_birth' => '2001-05-06',
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Taylor Updated')
            ->assertJsonPath('data.phone', '555-0102');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Taylor Updated',
            'email' => 'taylor@example.com',
        ]);
    }

    public function test_update_returns_422_for_invalid_student_data(): void
    {
        $student = Student::create([
            'name' => 'Taylor Student',
            'email' => 'taylor@example.com',
            'phone' => '555-0100',
        ]);

        $this->putJson("/api/students/{$student->id}", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'phone']);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Taylor Student',
        ]);
    }

    public function test_destroy_deletes_a_student_and_returns_204(): void
    {
        $student = Student::create([
            'name' => 'Taylor Student',
            'email' => 'taylor@example.com',
            'phone' => '555-0100',
        ]);

        $this->deleteJson("/api/students/{$student->id}")->assertNoContent();

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_missing_student_returns_404(): void
    {
        $this->getJson('/api/students/9999')->assertNotFound();
    }
}
