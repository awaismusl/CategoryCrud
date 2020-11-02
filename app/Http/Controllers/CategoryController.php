<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryContract;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;
    /**
     * CategoryController constructor.
     * @param CategoryContract $categoryRepository
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Categories', 'List of all categories');
        return view('category.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Categories', 'Create Category');
        return view('category.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->createCategory($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }

        $this->setFlashMessage('Category added successfully' ,'success');
        $this->showFlashMessages();

        return redirect()->route('categories.edit', $category->id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findCategoryById($id);

        $this->setPageTitle('Categories', 'Edit Category : '.$category->name);

        return view('category.edit',
            compact('category'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $params['id'] = $id;

        $category = $this->categoryRepository->updateCategory($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating category.', 'error', true, true);
        }
        return $this->responseRedirectBack('Category updated successfully' ,'success',false, false);
    }

    public function destroy($id)
    {
        $cat = $this->categoryRepository->findCategoryById($id);

        $category = null;
        if ($cat)
            $category = $this->categoryRepository->deleteCategory($id);


        if ( \request()->ajax())
        {
            if (!$category)
            {
                $view = (string) view('attributes.partials.affected-products' , compact('affected_products'));

                return response()->json([ 'status' => 'failed', 'view' => $view ]);
            }
            return response()->json( ['status' => 'success', 'message' => 'Category deleted successfully'] );
        }

        if (!$category)
            return $this->responseRedirectBack('Error occurred while deleting category.', 'error', true, true);

        return $this->responseRedirect('categories.index', 'Category deleted successfully' ,'success',false, false);

    }
}
