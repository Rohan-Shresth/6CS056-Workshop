<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCourseCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_crud_and_email_validation(): void
    {
        $this->get('/')->assertRedirect('/students');
        $this->get('/students')->assertOk()->assertSee('No students exist yet.');

        $this->post('/students', [
            'name' => 'Avery Student',
            'email' => 'avery@example.com',
            'phone' => '555-0100',
            'address' => 'Main Street',
            'date_of_birth' => '2000-01-02',
        ])->assertRedirect('/students')->assertSessionHas('success', 'Student created successfully.');

        $student = Student::firstOrFail();
        $this->assertDatabaseHas('students', ['email' => 'avery@example.com']);
        $this->get('/students')
            ->assertSee('Avery Student')
            ->assertSee('avery@example.com')
            ->assertSee('name="_method" value="DELETE"', false)
            ->assertSee('name="_token"', false);
        $this->get("/students/{$student->id}")->assertOk()->assertSee('Main Street')->assertSee('2000-01-02');
        $this->get("/students/{$student->id}/edit")->assertOk()->assertSee('name="_method" value="PUT"', false);

        $this->put("/students/{$student->id}", [
            'name' => 'Avery Updated',
            'email' => 'avery@example.com',
            'phone' => '555-0101',
            'address' => '',
            'date_of_birth' => '',
        ])->assertRedirect('/students')->assertSessionHas('success', 'Student updated successfully.');
        $this->assertDatabaseHas('students', ['id' => $student->id, 'name' => 'Avery Updated']);

        $this->from('/students/create')->post('/students', [
            'name' => 'Another Student',
            'email' => 'avery@example.com',
            'phone' => '555-0102',
        ])->assertRedirect('/students/create')->assertSessionHasErrors(['email']);

        $this->from('/students/create')->post('/students', [
            'name' => 'Preserved Name',
            'email' => 'not-an-email',
            'phone' => '',
        ])->assertRedirect('/students/create')->assertSessionHasErrors(['email', 'phone']);
        $this->get('/students/create')
            ->assertSee('value="Preserved Name"', false)
            ->assertSee('value="not-an-email"', false);

        $this->delete("/students/{$student->id}")
            ->assertRedirect('/students')
            ->assertSessionHas('success', 'Student deleted successfully.');
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_course_crud_and_validation(): void
    {
        $this->get('/courses')->assertOk()->assertSee('No courses exist yet.');
        $this->get('/courses/create')->assertOk()->assertSee('name="_token"', false);

        $this->post('/courses', [
            'name' => 'Web Development',
            'description' => 'An introductory course.',
            'duration' => '8',
            'fee' => '450.00',
            'difficulty' => 'Medium',
            'is_active' => '1',
        ])->assertRedirect('/courses')->assertSessionHas('success', 'Course created successfully.');

        $course = Course::firstOrFail();
        $this->assertDatabaseHas('courses', ['name' => 'Web Development', 'is_active' => true]);
        $this->get('/courses')->assertSee('Web Development')->assertSee('Active');
        $this->get("/courses/{$course->id}")->assertOk()->assertSee('An introductory course.');
        $this->get("/courses/{$course->id}/edit")->assertOk()->assertSee('name="_method" value="PUT"', false);

        $this->put("/courses/{$course->id}", [
            'name' => 'Web Development Updated',
            'description' => '',
            'duration' => '10',
            'fee' => '500',
            'difficulty' => 'Hard',
            'is_active' => '0',
        ])->assertRedirect('/courses')->assertSessionHas('success', 'Course updated successfully.');
        $this->assertDatabaseHas('courses', ['id' => $course->id, 'name' => 'Web Development Updated', 'is_active' => false]);

        $this->from('/courses/create')->post('/courses', [
            'name' => '',
            'description' => '',
            'duration' => 'many',
            'fee' => 'free',
            'difficulty' => 'Expert',
            'is_active' => '0',
        ])->assertRedirect('/courses/create')->assertSessionHasErrors(['name', 'duration', 'fee', 'difficulty']);

        $this->delete("/courses/{$course->id}")
            ->assertRedirect('/courses')
            ->assertSessionHas('success', 'Course deleted successfully.');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
