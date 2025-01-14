@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
<h1>商品一覧</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">商品一覧</h3>

                <!-- 検索機能 -->
                <div class="card-tools">
                    <form action="{{ route('items.index') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="名前で検索" value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">検索</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- 検索機能終わり -->
                <!-- mr-3で商品登録ボタンと検索の間にスペースを空ける -->
                <div class="card-tools mr-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>名前</th>
                            <th>種別</th>
                            <th>詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->detail }}</td>
                            <td>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary btn-sm">編集</a>
                            </td>
                            <td>
                                <form action="{{ route('items.delete', $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if(empty($items))
                        <tr>
                            <td colspan="5">検索結果が見つかりません。</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop