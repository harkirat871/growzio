<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(): View
    {
        $allCategories = Category::withProductsCountAllSlots()->get()->keyBy('id');
        
        $rootCategories = $allCategories->filter(function ($category) {
            return $category->parent_id === null;
        })->sortBy('name')->values();
        
        foreach ($allCategories as $category) {
            if ($category->parent_id !== null && isset($allCategories[$category->parent_id])) {
                $parent = $allCategories[$category->parent_id];
                if (!$parent->relationLoaded('children')) {
                    $parent->setRelation('children', collect());
                }
                $parent->children->push($category);
            }
        }
        
        $this->sortChildren($rootCategories);
        
        return view('admin.categories.index', compact('rootCategories'));
    }

    private function sortChildren($categories)
    {
        foreach ($categories as $category) {
            if ($category->children->isNotEmpty()) {
                $category->children = $category->children->sortBy('name')->values();
                $this->sortChildren($category->children);
            }
        }
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $parentId = null;
        if (!empty($validated['parent_name'])) {
            $parent = Category::whereRaw('LOWER(name) = ?', [strtolower(trim($validated['parent_name']))])->first();
            if (!$parent) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['parent_name' => 'Parent category not found.']);
            }
            $parentId = $parent->id;
        }

        $existingCategory = Category::where('parent_id', $parentId)
            ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
            ->first();

        if ($existingCategory) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'A category with this name already exists under the same parent.']);
        }

        $categoryData = [
            'name' => trim($validated['name']),
            'parent_id' => $parentId,
            'is_active' => $validated['is_active'] ?? true,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $image->getClientOriginalName());
            $dir = public_path('categories');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $image->move($dir, $imageName);
            $categoryData['image_path'] = 'categories/' . $imageName;
        }

        Category::create($categoryData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $excludeIds = array_merge([$category->id], $category->getDescendantIds());
        $parentOptions = Category::whereNotIn('id', $excludeIds)->orderBy('name')->get();

        return view('admin.categories.edit', compact('category', 'parentOptions'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|different:' . $category->id,
            'is_active' => 'boolean',
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // Preserve existing parent_id when field is not in request (e.g. form omitted it)
        $parentId = $category->parent_id;
        if (array_key_exists('parent_id', $request->all())) {
            $p = $validated['parent_id'] ?? null;
            $parentId = ($p === '' || $p === null) ? null : (int) $p;
        }

        $updateData = [
            'name' => $validated['name'],
            'parent_id' => $parentId,
            'is_active' => $validated['is_active'] ?? true,
        ];

        if ($request->hasFile('image')) {
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $image->getClientOriginalName());
            $dir = public_path('categories');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $image->move($dir, $imageName);
            $updateData['image_path'] = 'categories/' . $imageName;
        }

        $category->update($updateData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Products will have their category_id set to null due to nullOnDelete constraint
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
