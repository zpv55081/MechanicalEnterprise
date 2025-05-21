@extends('layout.tempBase')

@php
    $pTitle = $model->meta()->title;
    $pDescription = $model->meta()->description;

    $h1 = $model->meta()->h1;
    $pageSubtitle = $model->meta()->subtitle;
@endphp

@section('seo')
    <x-seo.meta_tags :title="$pTitle" :description="$pDescription" />

    <x-seo.open_graph :title="$pTitle" :description="$pDescription" />
@endsection

@section('head')
    @vite(['../geo.scss'])
@endsection
@section('footer')
    @vite(['../geo.js'])
@endsection

@section('content')
    @include('component.banner.bannFromMedia', [
        'title' => $h1,
        'subtitle' => $pageSubtitle,
        'modelLocal' => $model,
        'callButton' => [
            'ym_goal' => 'fos-cons',
            'btn_text' => 'Консультация',
        ],
    ])

    @if ($childs->count())
        <section class="search-settlements mg-160 container">
            <h2 class="t--center">Города и посёлки</h2>
            <div class="seach-form mt-60 m-inline-auto">
                <form class="form-search" data-list="{{ $searchList }}">
                    <input type="text" value="" class="settlements-input"
                        placeholder="Введите ваш населённый пункт">
                </form>
            </div>

            <div class="search-text ok">
                <div class="t--center mt-60 search_ok">Или выберите из списка ниже:</div>
                <div class="search_fail t--center">
                    К сожалению, такого варианта <span class="t--bold">нет в списке</span>.<br>
                    Попробуйте выбрать вручную из предложенных вариантов.
                </div>
            </div>

            <ul class="settlements-list mt-60">
                @foreach ($childs as $child)
                    <li class="jscitem @if (!$output_letter) empty-letter @endif">
                        @if ($output_letter)
                            <span>{{ $output_letter }}</span>
                        @endif
                        <a href="{{ $route }}">
                            {{ $child->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <x-forms.openforms.operator
        :title="'Ответим на любые вопросы'"
        :blockClasses="'bg--gray'"
        :buttonText="'Заказать звонок'" />

@endsection

@once
    @push('footInlJs')
    @endpush
@endonce
