<?php

use App\Models\Citizen;
use App\Models\License;
use App\Models\Violation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('that true is true', function () {
    expect(true)->toBeTrue();
});

it('GET api/citizens to be 200', function () {
    $response = $this->getJson("/api/citizens");
    $response->assertStatus(200);
});

it('POST api/citizens to be 201', function () {
    $data = ["name" => "Test Testov", "address" => "Ulitsa Testova"];
    $response = $this->postJson("/api/citizens", $data);
    $response->assertStatus(201)->assertJsonFragment(["name" => "Test Testov", "address" => "Ulitsa Testova"]);
});

it('GET api/citizens/citizen to be 200', function () {
    $citizen = Citizen::factory()->create();
    $response = $this->getJson("/api/citizens/$citizen->id");
    $response->assertStatus(200);
});
it('PUT api/citizens/citizen to be 200', function () {
    $citizen = Citizen::factory()->create();
    $new_data = [
        "name" => "Testa Testova",
        "address" => "Nova Ulitsa"
    ];
    $response = $this->putJson("/api/citizens/$citizen->id", $new_data);
    $response->assertStatus(200)->assertJsonFragment([
        "id" => $citizen->id,
        "name" => "Testa Testova",
        "address" => "Nova Ulitsa"
    ]);
});

it('DELETE api/citizens/citizen to be 204', function () {
    $citizen = Citizen::factory()->create();
    $response = $this->deleteJson("/api/citizens/$citizen->id");
    $response->assertStatus(204);
});

it('GET api/citizens/citizen/licenses to be 200', function () {
    $citizen = Citizen::factory()->create();
    $response = $this->getJson("/api/citizens/$citizen->id/licenses");
    $response->assertStatus(200);
});

it('POST api/citizens/citizen/licenses to be 201', function () {
    $citizen = Citizen::factory()->create();
    $data = ["type" => "test"];
    $response = $this->postJson("/api/citizens/$citizen->id/licenses", $data);
    $response->assertStatus(201)->assertJsonFragment(["citizen_id" => $citizen->id, "type" => "test"]);
});

it('GET api/citizens/citizen/licenses/license to be 200', function () {
    $citizen = Citizen::factory()->create();
    $license = License::factory()->create();
    $response = $this->getJson("/api/citizens/$citizen->id/licenses/$license->id");
    $response->assertStatus(200);
});

it('PUT api/citizens/citizen/licenses/license to be 200', function () {
    $citizen = Citizen::factory()->create();
    $license = License::factory()->create(["citizen_id" => $citizen->id]);
    $new_data = ["type" => "new test"];
    $response = $this->putJson("/api/citizens/$citizen->id/licenses/$license->id", $new_data);
    $response->assertStatus(200)->assertJsonFragment(["citizen_id" => $citizen->id, "id" => $license->id, "type" => "new test"]);
});

it('DELETE api/citizens/citizen/licenses/license to be 204', function () {
    $citizen = Citizen::factory()->create();
    $license = License::factory()->create(["citizen_id" => $citizen->id]);
    $response = $this->deleteJson("/api/citizens/$citizen->id/licenses/$license->id");
    $response->assertStatus(204);
});

it('GET api/citizens/citizen/licenses/license/violations to be 200', function () {
    $citizen = Citizen::factory()->create();
    $license = License::factory()->create(["citizen_id" => $citizen->id]);
    $response = $this->getJson("/api/citizens/$citizen->id/licenses/$license->id/violations");
    $response->assertStatus(200);
});

it('GET api/citizens/citizen/licenses/license/violations/violation to be 200', function () {
    $citizen = Citizen::factory()->create();
    $license = License::factory()->create(["citizen_id" => $citizen->id]);
    $violation = Violation::factory()->create(["license_id" => $license->id]);
    $response = $this->getJson("/api/citizens/$citizen->id/licenses/$license->id/violations/$violation->id");
    $response->assertStatus(200);
});
