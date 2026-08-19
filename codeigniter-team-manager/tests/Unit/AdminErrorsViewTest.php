<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class AdminErrorsViewTest extends CIUnitTestCase
{
    public function testErrorsViewRendersEachValidationError(): void
    {
        $html = view('admin/errors', [
            'errors' => [
                'name' => 'The Name field is required.',
                'email' => 'The Email field must contain a valid email address.',
            ],
        ]);

        $this->assertStringContainsString('class="error error-list"', $html);
        $this->assertStringContainsString('The Name field is required.', $html);
        $this->assertStringContainsString('The Email field must contain a valid email address.', $html);
    }

    public function testErrorsViewDoesNotRenderMarkupWhenNoErrorsExist(): void
    {
        $html = view('admin/errors', ['errors' => []]);

        $this->assertStringNotContainsString('class="error error-list"', $html);
        $this->assertStringNotContainsString('error-item', $html);
    }
}
