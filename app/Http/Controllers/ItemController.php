<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::all();

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ],
            [
                'name.required' => '名前は必須です。',
                'name.max' => '名前の文字数は、100文字以下である必要があります。'
            ]
        );

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    // 商品削除
    public function delete($id)
{
    $item = Item::find($id);

    if ($item) {
        $item->delete();
        return redirect('/items')->with('success', '削除しました。');
    }

    return redirect('/items')->with('error', '削除に失敗しました。');
}

    // 検索機能
    public function serch(Request $request)
{
    // 検索クエリの取得
    $search = $request->input('search');

    // 検索処理
    $query = Item::query();
    if ($search) {
        $query->where('name', 'LIKE', "%{$search}%");
    }

    // 検索結果を取得
    $items = $query->get();

    return view('item.index', compact('items', 'search'));
}

    // 編集機能
    public function edit($id)
{
    $item = Item::find($id);

    if (!$item) {
        return redirect('/items')->with('error', '商品が見つかりませんでした。');
    }

    return view('item.edit', compact('item'));
}

public function update(Request $request, $id)
{
    $item = Item::find($id);

    if (!$item) {
        return redirect('/items')->with('error', '商品が見つかりませんでした。');
    }

    // バリデーション
    $this->validate($request, [
        'name' => 'required|max:100',
        'type' => 'nullable|max:100',
        'detail' => 'nullable|max:500',
    ],
    
        [
            'name.required' => '名前は必須です。',
            'name.max' => '名前の文字数は、100文字以下である必要があります。',
            'type.max' => '種別の文字数は、100文字以下である必要があります。',
            'detail.max' => '詳細の文字数は、500文字以下である必要があります。'
        ]
    
);

    // データ更新
    $item->update([
        'name' => $request->name,
        'type' => $request->type,
        'detail' => $request->detail,
    ]);

    return redirect('/items')->with('success', '商品情報を更新しました。');
}

}
