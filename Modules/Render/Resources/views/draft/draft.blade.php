@extends('render::layouts.blank-slate')
@section('title', 'Draft')
@section('content')

<link href="{{ asset('/render-assets/render/tailwind.css') }}" rel="stylesheet">
<link href="{{ asset('/render-assets/draft/draft.css') }}" rel="stylesheet">
<script src="{{ asset('/render-assets/draft/draft.js') }}"></script>
<link rel="stylesheet" href="https://use.typekit.net/pnf6ltz.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;500;700&display=swap" rel="stylesheet">


@php
$picks = ['14', '26', '30', '47'];
// $pickedPlayers = [['Kyle George', 'Emerson College'], ['---', '---'], ['---', '---'], ['---', '---']];
$pickedPlayers = [['Kyle George', 'Emerson College'], ['Kyle George', 'Emerson College'], ['---', '---'], ['---',
'---']];
$tabs = ['fas fa-th-list', 'fab fa-twitter', 'fab fa-instagram', 'fas fa-question-square']
@endphp

{{-- <div id="fold-line" class="absolute w-full border-dashed border border-red-600 z-50 opacity-50"></div> --}}
<main id="draft" class="h-full w-full bg-black flex justify-center align-center p-5">
    <div style="max-width: 100rem" class="rounded-md overflow-hidden w-full flex lg:flex-row flex-col">
        <!-- * Left Block * -->
        <section class="bg-gray-800 lg:w-3/4 w-full lg:h-full border-r-1 border-gray-900 px-8">
            <div class="w-full bg-transparent relative flex justify-between flex-wrap">
                <!-- * Header * -->
                <div id="logos" class="h-32 px-4 py-8 flex items-center relative">
                    <div class="relative border-r w-3/4 border-white pr-8 h-full">
                        @include('render::draft.svg.nba-draft-logo')
                    </div>
                    <div class="relative pl-8 w-1/4 h-full">
                        @include('render::draft.svg.celtics-secondary-logo')
                    </div>
                </div>
                <div class="h-32 py-8 flex relative flex-col flex-1 justify-center items-center">
                    <div class="w-full max-w-sm flex justify-center flex-col">
                        <p class="futura font-bold text-BOS-500 uppercase text-center">Celtics Picks
                        </p>
                        <div class="flex justify-between w-full">
                            @foreach($picks as $i => $pick)
                            <p style="font-size: 2.5rem"
                                class="text-white mb-4 leading-none py-1 font-bold futura {{ $i === 2 || $i === 3 ? 'opacity-25' : '' }}">
                                {{ $pick }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- * Video * -->
                <div class="w-full">
                    <div id="video" class="bg-black w-full rounded overflow-hidden"></div>
                </div>
                <!-- * Celtics Picks * -->
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-x-8 gap-y-10 w-full p-4 py-8">
                    @foreach($picks as $i => $pick)
                    <div class="flex items-center order-{{$i === 2 ? 2 : $i + 1}}">
                        <p class="futura text-center text-xl font-semibold leading-snug uppercase text-white pr-4">
                            {{$pick}}
                        </p>
                        <div class="flex flex-col border-l border-gray-600 justify-between pl-4">
                            <p class="font-bold text-BOS-500 leading-snug">
                                {{$pickedPlayers[$i][0]}}
                            </p>
                            <p class="font-light text-gray-300 text-xs">
                                {{$pickedPlayers[$i][1]}}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- * Ad Space * -->
        </section>
        <!-- * Panel * -->
        <section class="lg:w-1/4 w-full bg-BOS-900 relative">
            <!-- * Current Pick * -->
            <div class="w-full h-24 p-2 flex items-center justify-center bg-green-700">
                <p class="text-white futura uppercase font-bold text-3xl pr-6 border-r border-gray-400">Pick 27</p>
                <div class="p-2 h-full pl-6">
                    <img class="h-full"
                        src="https://www.nba.com/resources/static/team/v2/celtics/cdn/logos/teams/white/NYK.png" />
                </div>
            </div>
            <!-- * Panel Navigation * -->
            <nav id="panel-navigation" class="w-full h-16 bg-BOS-600 relative flex justify-between items-center">
                @foreach($tabs as $i => $tab)
                <div class="py-4 h-full px-2 flex-1 border-t-2 flex justify-center items-center 
                    {{$i === 0 ? 'border-white' : 'border-BOS-800'}}">
                    <i class="text-xl opacity-50 text-white {{$tab}} {{$i === 0 ? 'opacity-100' : 'opacity-50'}}"></i>
                </div>
                @endforeach
            </nav>
            <!-- * Panel Content * -->
            <div class="w-full">
                @foreach($order as $i => $pick)
                <div class="flex h-16 px-4 my-6 w-full">
                    <div class="p-3 py-2 flex items-center">
                        <p class="text-white font-bold text-xl">{{$pick["field_pick_number"]}}</p>
                    </div>
                    <div class="flex w-1/4 py-3 flex-col justify-center items-center p-3 border-r border-gray-500">
                        <img class="h-full"
                            src="https://www.nba.com/resources/static/team/v2/celtics/cdn/logos/teams/white/{{$pick["team_tricode"]}}.png" />
                        {{-- <p>{{$pick["team_tricode"]}}</p> --}}
                    </div>
                    <div class="flex-1 w-full p-4 py-2  ">
                        <p class="font-bold text-white leading-snug">
                            {{$pick["field_draft_prospect"]}}
                        </p>
                        <p class="font-light text-gray-300 text-xs">
                            {{$pick["prospect_position"]}}, {{$pick["prospect_height"]}},
                            {{$pick["prospect_weight"]}}lbs
                        </p>
                        <p class="font-light text-gray-300 text-xs">
                            {{$pick["prospect_college"]}}
                        </p>
                    </div>
                </div>
                @endforeach
                <div>
        </section>
    </div>
</main>
@endsection