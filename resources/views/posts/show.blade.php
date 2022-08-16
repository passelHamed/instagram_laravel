<x-app-layout>
    <x-slot name="header">

    </x-slot>


    <div class="grid grid-cols-5 mt-7 gap-4">
        <div class="col-start-2 col-span-3">
            <div class="grid grid-cols-5">
                <div class="col-span-3">
                    <div class="flex justify-center">
                        <img src="/storage/{{ $post->image_path }}" alt="">
                    </div>
                </div>

                <div class="col-span-2 bg-white flex flex-col">
                    <div class="flex flex-row p-3 border-b border-solid border-gray-300 items-center justify-between">
                        <div class="flex flex-row items-center">
                            <img src="/storage/{{ $post->user->profile_photo_path }}" alt="{{ $post->user->username }}" class="rounded-full h-10 w-10 mr-3">
                            <a href="/{{ $post->user->username }}" class="font-bold hover:underline">{{ $post->user->username }}</a>
                        </div>

                        @if (auth()->user()->id == $post->user_id)
                            <div class="text-gray-500">
                                <a href="/posts/{{ $post->id }}/edit"><i class="fas fa-edit"></i></a>
                                <span class="font-bold mx-2">|</span>
                                <form class="inline-block" action="/posts/{{ $post->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are You sure you want to delete this post? this will delete your post permanently.')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div>
                                <button class="bg-blue-500 rounded-lg shadow px-2 py-1 text-white">Follow</button>
                            </div>
                        @endif

                    </div>
                    <div class="border-b border-solid border-gray-300 h-full">
                        <div class="gird grid-cols-5 overflow-y-auto">
                            <div class="col-span-1 m-3">
                                <a href="/{{ auth()->user()->username }}"><img src="/storage/{{ $post->user->profile_photo_path }}" alt="{{ $post->user->username }}" class="rounded-full h-10 w-10"></a>
                            </div>
                            <div class="col-span-4 mt-5 mr-7">
                                <a href="/{{ $post->user->username }}" class="font-bold hover:underline ml-2">{{ $post->user->username }}:</a>
                                <span>{{ $post->post_caption }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-col item-start pl-4 pb-1">
                            <div class="flex flex-row item-cover">
                                <button class="text-2xl mr-3 focus:outline-none"><i class="far fa-heart"></i></button>
                                <button class="text-2xl mr-3 focus:outline-none"><i class="far fa-comment"></i></button>
                                <button class="text-2xl mr-3 focus:outline-none"><i class="far fa-share-square"></i></button>
                            </div>
                            <span>{{ __('Liked by') }}</span>
                        </div>
                        <div class="border-b border-solid border-gray-300 pl-4 pb-1 text-xs">
                            {{ $post->created_at->format('M j o') }}
                        </div>
                    </div>
                    <div class="p-4">
                        <form action="/commets" method="get" autocomplete="off">
                        @csrf
                            <div class="flex flex-row item-center justify-between">
                                <input class="w-full outline-none border-none p-1" type="text" name="comment" id="comment" placeholder="{{ __('Add comment') }}" autofocus>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <button type="submit" class="text-blue-500 font-semibold hover:text-blue-700">{{ __('Post') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>