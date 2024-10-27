@extends('layouts.app2')

@section('contents')
<div class="new_home_web relative">
  <div class="max-w-6xl mx-auto px-4">
    <img class="absolute inset-0 w-4/5 h-full object-cover pointer-events-none" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/aw65.png">
    
    <div class="flex flex-col items-center mt-12 mb-10 z-50">
      <div class="text-center mb-5">
        <p class="text-4xl font-semibold leading-tight">
          Get in
          <span class="text-orange-600">touch</span>
        </p>
        <div class="h-2 w-40 bg-red-400 mt-2"></div>
      </div>
      <p class="text-center text-gray-600 max-w-2xl">
        If you have any questions about renting, you can use this to contact us.
      </p>
    </div>
    <div class="flex justify-center mb-10 z-50">
      <div class="w-full max-w-3xl px-2">
        <form class="bg-white shadow-md rounded-lg p-8" action="{{ route('contact.store') }}" method="POST">
          @csrf
          <div class="grid grid-cols-1 gap-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <input class="input h-12 border-2 border-gray-400 rounded px-4" type="text" name="full_name" placeholder="Full Name" required>
              <input class="input h-12 border-2 border-gray-400 rounded px-4" type="email" name="email" placeholder="Email Address" required>
              <input class="input h-12 border-2 border-gray-400 rounded px-4" type="tel" name="phone_number" placeholder="Phone Number">
            </div>
            <textarea class="textinput h-48 border-2 border-gray-400 rounded px-4 py-2" name="message" placeholder="Message" required></textarea>
          </div>
          <button type="submit" class="send w-full h-12 bg-red-500 text-white font-semibold rounded mt-4 hover:bg-red-600">
            Send
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
