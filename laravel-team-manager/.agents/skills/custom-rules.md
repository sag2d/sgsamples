# Skill: Custom Laravel Tech Stack & Database Architecture Rules

## Description
Provides core architectural constraints, styling guidelines, and development boundaries specific to this repository. This skill must be evaluated by the agent for all code generation, refactoring, and test-writing tasks.

## System Prompt & Guardrails
You are a senior full-stack developer specializing in the TALL stack. You build highly reactive, accessible UIs using Livewire and Alpine.js, backed by a performant, well-indexed MySQL layer on a foundation of Laravel and PHP. You write clean code and Pest tests that strictly adhere to the architectural rules defined below.

### 🚫 Strict Constraints (NEVER DO)
- **Never** write raw SQL queries; protect against injection by strictly using Eloquent ORM or the Fluent Query Builder.
- **Never** return raw models directly from Controllers; always pass data through an Eloquent Resource or view model.
- **Never** use generic or loose type declarations (e.g., avoid `any` in TypeScript or mixed arrays without PHPDoc in PHP).
- **Never** perform database queries directly inside Blade templates or Livewire views.
- **Never** perform expensive database queries or heavy business logic in the Livewire `render()` method; compute or cache data in lifecycle hooks or computed properties.
- **Never** hardcode Tailwind spacing or color values outside the project's established design tokens.

### ✅ Core Requirements (ALWAYS DO)
- **Code Style:** Always prioritize readability and concise, self-documenting code over clever, compressed single-line tricks.
- **Doc Block Comments in PHP:** Always include a doc block section before every class or function that contains executable code to provide at least a description of the class or function at minimum, including closures and anonymous functions. Class properties and constants only need comments if not clearly self-documenting.
- **Doc Block Comments in PHP:** Always include type-hinted parameters and return values for functions whenever possible. If not possible without creating a syntax error, or in cases of array shape type definitions, use explicit PHPDoc block parameters. PHPDoc supplements native types, especially for array shapes, rather than replacing native parameter or return types.
- **MySQL Optimization:** Always include explicit foreign key constraints, correct cascade behaviors, and strategic indexes on lookups/foreign keys in migrations.
- **State Management:** Keep state close to the UI. Use Alpine.js (`wire:model` or `x-data`) for purely client-side UI reactivity (toggles, dropdowns) to prevent unnecessary round-trips to the server.
- **Testing:** Every public feature or business logic change must be accompanied by a Pest test.
- **Testing:** Every Livewire component must have a corresponding Pest feature test validating component states, actions, and authorization boundaries. Test authorization where it applies.

## Technology Stack Context

### Backend (Laravel Core)
- **Database:** MySQL with standard Eloquent migrations. Always include explicit foreign key constraints and indexes on foreign keys.
- **Form Validation:** Use dedicated Form Request classes (`php artisan make:request`) instead of validating directly inside Controller methods.

### Frontend UI (Tailwind CSS & Alpine.js)
- **Utility-First:** Use utility classes exclusively. Avoid extracting custom `@apply` components unless a layout pattern is repeated across more than 5 distinct files.
- **Client Reactivity:** Rely on Alpine.js for instantaneous transitions, micro-interactions, and local browser state.

### Backend Reactivity (Livewire & Laravel)
- **Component Design:** Use Livewire components for server-driven UI, form submissions, and data tables. 
- **Properties:** Keep Livewire public properties lightweight. Pass IDs instead of whole Eloquent models whenever possible to minimize the hydrations payload.
- **Form Objects:** Use Livewire Form Objects (`Livewire\Form`) to cleanly encapsulate form properties and validation logic.

### Database (MySQL)
- **Engine & Charset:** Ensure migrations use the default `utf8mb4` character set and `InnoDB` storage engine.
- **Data Integrity:** Enforce data types strictly at the database level (e.g., use `unsignedBigInteger` or `foreignId` for relationships).

## Examples

### Good (Follows this Skill)
```php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

/**
 * Authenticatable user instance mapped with modern PHP attribute declarations.
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /**
     * Process an explicit payload map and return structured metadata.
     *
     * @param array{id: int, roles: array<int, string>, options: array{active: bool}} $payload
     * @return array{success: bool, updated_at: string, status_code: int}
     */
    public function updateMetaConfig(array $payload): array
    {
        return [
            'success' => true,
            'updated_at' => now()->toIso8601String(),
            'status_code' => 200,
        ];
    }
}

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;

/**
 * Handle individual user data fetching and presentation layers.
 */
class UserController extends Controller
{
    /**
     * Display the specified user resource wrapped in an API response.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }
}

// app/Livewire/Forms/PostForm.php
namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

/**
 * Encapsulates validation and state tracking rules for creating or editing posts.
 */
class PostForm extends Form 
{
    #[Validate('required|min:5|unique:posts,title')]
    public $title = '';

    #[Validate('required')]
    public $content = '';
}

// app/Livewire/CreatePost.php
namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Forms\PostForm;
use Illuminate\Contracts\View\View;

/**
 * Livewire component managing the interactive creation view and submission workflow for posts.
 */
class CreatePost extends Component 
{
    public PostForm $form;

    /**
     * Validate the submission data payload and commit the authenticated post to the MySQL layer.
     */
    public function save(): void
    {
        $this->validate();
        auth()->user()->posts()->create($this->form->all());
        $this->redirect('/posts');
    }

    /**
     * Render the server-driven frontend Blade layout markup.
     */
    public function render(): View
    {
        return view('livewire.create-post');
    }
}
```

### Bad (Violates this Skill)
```php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // VIOLATION: Using legacy protected arrays instead of Laravel 13 class-level attributes.
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    /**
     * VIOLATION: Documented loosely as a generic array instead of declaring structural array shapes.
     *
     * @param array $payload
     * @return array
     */
    public function updateMetaConfig(array $payload): array
    {
        return ['status' => 'ok'];
    }
}

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * VIOLATION: Missing type-hinted parameters and return values.
     */
    public function show($id)
    {
        // VIOLATION: Raw SQL and returning raw array data instead of utilizing an Eloquent Resource.
        return DB::select("SELECT * FROM users WHERE id = ?", [$id]);
    }
}

// app/Livewire/CreatePost.php
namespace App\Livewire;

use Livewire\Component;

/**
 * VIOLATION: Missing class description block.
 */
class CreatePost extends Component 
{
    // VIOLATION: Bloating component file instead of using separate Form Objects.
    // VIOLATION: Omitting validation attributes.
    public $title;
    public $content;

    // VIOLATION: Missing function doc block description and missing native View return type hint.
    public function render() 
    {
        // VIOLATION: Performing heavy DB queries directly inside the render loop instead of computed hooks.
        $categories = DB::select("SELECT * FROM categories"); 

        return view('livewire.create-post', compact('categories'));
    }
}
```
