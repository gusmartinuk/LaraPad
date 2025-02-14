<!-- Navigation Bar - Mobile: Top, Desktop: Side -->
<div class="bg-gray-900 text-white">
    <!-- Mobile Menu -->
    <div class="md:hidden flex justify-between items-center p-4 border-b border-gray-700">
        <span class="font-bold text-lg">📖 LaraPad</span>
        <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Menu Items -->
    <div id="mobileMenu" class="hidden md:block bg-gray-900">
        <ul class="space-y-2 p-4">
            <li class="hover:bg-gray-700 rounded-lg px-2 py-2">
                <a href="/dashboard" class="flex items-center">
                    🏠 <span class="ml-2">Dashboard</span>
                </a>
            </li>
            <li class="hover:bg-gray-700 rounded-lg px-2 py-2">
                <a href="/notes" class="flex items-center">
                    📝 <span class="ml-2">Notes</span>
                </a>
            </li>
            <li class="hover:bg-gray-700 rounded-lg px-2 py-2">
                <a href="/tags" class="flex items-center">
                    🏷️ <span class="ml-2">Tags</span>
                </a>
            </li>
            <li class="hover:bg-gray-700 rounded-lg px-2 py-2">
                <a href="/documents" class="flex items-center">
                    📂 <span class="ml-2">Documents</span>
                </a>
            </li>
            <li class="hover:bg-red-700 rounded-lg px-2 py-2">
                <form action="/logout" method="POST" class="flex items-center">
                    @csrf
                    🚪 <button type="submit" class="ml-2">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>
