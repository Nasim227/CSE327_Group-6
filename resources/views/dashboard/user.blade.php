@extends('layouts.blank')

@section('content')
{{-- Load Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@500&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">

<div class="min-h-screen bg-gray-50" x-data="{ 
    tshirtColor: 'white',
    cartStatus: 'idle',
    currentSize: 'M',
    customText: '',
    currentFont: 'sans-serif',
    hasImage: false,
    
    addToCart() {
        this.cartStatus = 'adding';
        setTimeout(() => {
            this.cartStatus = 'added';
            setTimeout(() => {
                this.cartStatus = 'idle';
            }, 2000);
        }, 600);
    },
    
    scrollToCollection() {
        document.getElementById('my-collection').scrollIntoView({ behavior: 'smooth' });
    },

    handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('uploadedDesign').src = e.target.result;
                this.hasImage = true;
            }
            reader.readAsDataURL(file);
        }
    },

    removeImage() {
        document.getElementById('uploadedDesign').src = '';
        document.getElementById('imageUpload').value = '';
        this.hasImage = false;
    }
}">
    {{-- Navigation Bar --}}
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white font-bold text-xs">S</div>
            <span class="font-bold text-xl tracking-tight">STUDIO</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-black transition-colors">Home</a>
            <button @click="scrollToCollection()" class="text-sm font-medium text-gray-500 hover:text-black transition-colors">Collections</button>
            <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                <span class="text-sm font-semibold">{{ Auth::user()->First_name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs bg-black text-white px-4 py-2 rounded-full hover:bg-gray-800 transition-colors">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        {{-- Hero Section --}}
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->First_name }}.</h1>
            <p class="text-gray-500">Your creative studio is ready. What will you create today?</p>
        </div>

        {{-- MAIN FEATURE: Custom T-Shirt Studio --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-3">
                {{-- Left: The Canvas (T-Shirt Preview) --}}
                <div class="lg:col-span-2 bg-gray-100 p-10 flex items-center justify-center relative min-h-[600px] overflow-hidden">
                    
                    <div class="relative w-full max-w-md mx-auto transition-transform duration-500 ease-out"
                         :style="`transform: scale(${currentSize === 'S' ? 0.8 : (currentSize === 'M' ? 0.95 : (currentSize === 'L' ? 1.1 : 1.3))})`">
                        {{-- Realistic T-Shirt SVG --}}
                        <div class="w-full aspect-[3/4] relative flex items-center justify-center">
                            <svg class="w-full h-full drop-shadow-xl transition-all duration-300" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <g :stroke="tshirtColor === 'white' ? 'rgba(0,0,0,0.1)' : 'rgba(255,255,255,0.2)'" stroke-width="4">
                                    <path 
                                        :fill="tshirtColor === 'white' ? '#ffffff' : (tshirtColor === 'black' ? '#1a1a1a' : (tshirtColor === 'navy' ? '#1e293b' : '#9ca3af'))"
                                        d="M358.5,64c-14.5,0-27.6,7.8-35.7,19.8c-18.4,27.3-49.2,45.2-84.3,45.2c-35.1,0-65.9-17.9-84.3-45.2
                                        C146.1,71.8,133,64,118.5,64h-10c-20.4,0-38.3,12.8-44.6,32l-15,80c-2.5,13.5,6.1,26.8,19.5,29.8l25.6,5.7V464
                                        c0,17.7,14.3,32,32,32h224c17.7,0,32-14.3,32-32V211.5l25.6-5.7c13.4-3,22-16.3,19.5-29.8l-15-80
                                        c-6.3-19.2-24.2-32-44.6-32H358.5z"
                                    />
                                </g>
                            </svg>
                            
                            {{-- The Design Overlay Area --}}
                            {{-- FIX: Adjusted left to 50% (Center) as requested --}}
                            <div id="designArea" class="absolute top-[33%] left-[50%] -translate-x-1/2 w-[26%] h-[32%] border-2 border-dashed border-gray-400/50 flex flex-col items-center justify-center overflow-hidden group hover:border-blue-500 transition-colors p-1">
                                
                                {{-- Image Layer --}}
                                <img id="uploadedDesign" src="" class="w-full h-full object-contain flex-1 z-10 mb-1" 
                                     :class="hasImage ? 'block' : 'hidden'" alt="Your Design">
                                
                                {{-- Text Layer --}}
                                <span x-text="customText" 
                                      class="z-20 text-center font-bold break-words max-w-full leading-tight"
                                      :style="`font-family: ${currentFont}`"
                                      :class="{
                                          'text-black': tshirtColor === 'white' || tshirtColor === 'heather',
                                          'text-white': tshirtColor === 'black' || tshirtColor === 'navy',
                                          'text-lg': customText.length < 10,
                                          'text-base': customText.length >= 10 && customText.length < 20,
                                          'text-xs': customText.length >= 20
                                      }">
                                </span>

                                {{-- Placeholder Text --}}
                                <p id="placeholderText" class="text-gray-400 text-xs text-center px-4 font-medium group-hover:text-blue-500 select-none absolute"
                                   :class="{'hidden': customText.length > 0 || hasImage}">
                                    Print Area<br><span class="opacity-75">(Image or Text)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Size Indicator --}}
                    <div class="absolute bottom-4 right-4 bg-white px-3 py-1 rounded-full text-xs font-bold shadow-sm text-gray-500">
                        Preview Size: <span x-text="currentSize"></span>
                    </div>
                </div>

                {{-- Right: Control Panel --}}
                <div class="p-10 flex flex-col justify-center bg-white h-full overflow-y-auto">
                    <div class="mb-6">
                        <span class="text-xs font-bold tracking-wider text-blue-600 uppercase mb-2 block">New Feature</span>
                        <h2 class="text-3xl font-bold mb-2">Custom Studio</h2>
                        <p class="text-gray-600 text-sm">Design your unique tee. Choose your fit, color, and add your personal touch.</p>
                    </div>

                    <div class="space-y-6">
                        {{-- Size Selection --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Size</label>
                            <div class="grid grid-cols-4 gap-2">
                                <button @click="currentSize = 'S'" class="py-2 text-sm font-bold rounded-lg border transition-all" :class="currentSize === 'S' ? 'border-black bg-black text-white' : 'border-gray-200 text-gray-600 hover:border-gray-300'">S</button>
                                <button @click="currentSize = 'M'" class="py-2 text-sm font-bold rounded-lg border transition-all" :class="currentSize === 'M' ? 'border-black bg-black text-white' : 'border-gray-200 text-gray-600 hover:border-gray-300'">M</button>
                                <button @click="currentSize = 'L'" class="py-2 text-sm font-bold rounded-lg border transition-all" :class="currentSize === 'L' ? 'border-black bg-black text-white' : 'border-gray-200 text-gray-600 hover:border-gray-300'">L</button>
                                <button @click="currentSize = 'XL'" class="py-2 text-sm font-bold rounded-lg border transition-all" :class="currentSize === 'XL' ? 'border-black bg-black text-white' : 'border-gray-200 text-gray-600 hover:border-gray-300'">XL</button>
                            </div>
                        </div>

                        {{-- Color Selection --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">T-Shirt Color</label>
                            <div class="flex gap-3">
                                <button @click="tshirtColor = 'white'" class="w-8 h-8 rounded-full bg-white border border-gray-300 ring-offset-2 focus:ring-2 ring-black transition-all" :class="{ 'ring-2': tshirtColor === 'white' }"></button>
                                <button @click="tshirtColor = 'black'" class="w-8 h-8 rounded-full bg-black border border-gray-300 ring-offset-2 focus:ring-2 ring-black transition-all" :class="{ 'ring-2': tshirtColor === 'black' }"></button>
                                <button @click="tshirtColor = 'heather'" class="w-8 h-8 rounded-full bg-gray-400 border border-gray-300 ring-offset-2 focus:ring-2 ring-gray-400 transition-all" :class="{ 'ring-2': tshirtColor === 'heather' }"></button>
                                <button @click="tshirtColor = 'navy'" class="w-8 h-8 rounded-full bg-blue-900 border border-gray-300 ring-offset-2 focus:ring-2 ring-blue-900 transition-all" :class="{ 'ring-2': tshirtColor === 'navy' }"></button>
                            </div>
                        </div>

                        {{-- Customization Options --}}
                        <div class="space-y-4 border-t border-gray-100 pt-4">
                            {{-- Image Upload --}}
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                                    <button x-show="hasImage" @click="removeImage()" class="text-xs text-red-500 hover:text-red-700 font-medium">Remove Image</button>
                                </div>
                                <input type="file" id="imageUpload" accept="image/*" @change="handleImageUpload($event)"
                                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer"/>
                            </div>

                            {{-- Text Input & Font --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Add Text</label>
                                <div class="flex gap-2 mb-2">
                                    <input type="text" x-model="customText" placeholder="Type something..." 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                                </div>
                                
                                {{-- Font Selector --}}
                                <div class="grid grid-cols-3 gap-2">
                                    <button @click="currentFont = 'sans-serif'" class="px-2 py-1 text-xs border rounded hover:bg-gray-50" :class="currentFont === 'sans-serif' ? 'border-black bg-gray-100' : 'border-gray-200'" style="font-family: sans-serif">Sans</button>
                                    <button @click="currentFont = 'serif'" class="px-2 py-1 text-xs border rounded hover:bg-gray-50" :class="currentFont === 'serif' ? 'border-black bg-gray-100' : 'border-gray-200'" style="font-family: serif">Serif</button>
                                    <button @click="currentFont = 'monospace'" class="px-2 py-1 text-xs border rounded hover:bg-gray-50" :class="currentFont === 'monospace' ? 'border-black bg-gray-100' : 'border-gray-200'" style="font-family: monospace">Mono</button>
                                    <button @click="currentFont = '\'Lobster\', cursive'" class="px-2 py-1 text-xs border rounded hover:bg-gray-50" :class="currentFont.includes('Lobster') ? 'border-black bg-gray-100' : 'border-gray-200'" style="font-family: 'Lobster', cursive">Lobster</button>
                                    <button @click="currentFont = '\'Oswald\', sans-serif'" class="px-2 py-1 text-xs border rounded hover:bg-gray-50" :class="currentFont.includes('Oswald') ? 'border-black bg-gray-100' : 'border-gray-200'" style="font-family: 'Oswald', sans-serif">Bold</button>
                                    <button @click="currentFont = '\'Playfair Display\', serif'" class="px-2 py-1 text-xs border rounded hover:bg-gray-50" :class="currentFont.includes('Playfair') ? 'border-black bg-gray-100' : 'border-gray-200'" style="font-family: 'Playfair Display', serif">Elegant</button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-medium">Total</span>
                                <span class="text-2xl font-bold">$29.99</span>
                            </div>
                            
                            <button @click="addToCart()" 
                                class="w-full py-4 rounded-xl font-bold transition-all shadow-lg flex items-center justify-center gap-2"
                                :class="{
                                    'bg-black text-white hover:bg-gray-900 transform hover:-translate-y-1': cartStatus === 'idle',
                                    'bg-gray-800 text-gray-300 cursor-wait': cartStatus === 'adding',
                                    'bg-green-600 text-white transform scale-105': cartStatus === 'added'
                                }"
                                :disabled="cartStatus !== 'idle'">
                                <template x-if="cartStatus === 'idle'"><span>Add to Cart</span></template>
                                <template x-if="cartStatus === 'adding'">
                                    <div class="flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span>Adding...</span>
                                    </div>
                                </template>
                                <template x-if="cartStatus === 'added'">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Added to Cart!</span>
                                    </div>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secondary Section: My Collection --}}
        <div id="my-collection" class="scroll-mt-24">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold">My Collection</h3>
                <span class="text-sm text-gray-500">Products already delivered</span>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Order ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Items</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $order['id'] }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $order['date'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $order['items'] }}</td>
                            <td class="px-6 py-4 font-medium">{{ $order['total'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $order['status'] === 'Delivered' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $order['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
