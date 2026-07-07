<x-shop-layout>
    <x-slot name="title">Contact Us | Luxora Textiles</x-slot>

    <div class="max-w-5xl mx-auto space-y-12">
        <div class="text-center space-y-3">
            <span class="text-xs uppercase font-extrabold tracking-widest text-amber-500">Get in Touch</span>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-950 dark:text-white">Contact Our Styling Concierge</h1>
            <p class="text-gray-500 dark:text-gray-400 max-w-lg mx-auto text-sm">Whether you have questions about our bridal collections, custom fittings, or shipping times, our team is ready to assist.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Details -->
            <div class="space-y-6 md:col-span-1">
                <div class="glassmorphism p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-4">
                    <h3 class="font-bold text-gray-900 dark:text-white">Flagship Atelier</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Road No 36, Jubilee Hills,<br/>
                        Hyderabad, Telangana - 500033
                    </p>
                </div>
                <div class="glassmorphism p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-4">
                    <h3 class="font-bold text-gray-900 dark:text-white">Direct Contacts</h3>
                    <p class="text-sm text-gray-550 dark:text-gray-400 leading-relaxed">
                        Email: concierge@luxora.com<br/>
                        Phone: +91 40 87654321
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div class="md:col-span-2">
                <div class="glassmorphism p-8 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Send An Inquiry</h2>
                    <form onsubmit="event.preventDefault(); alert('Message sent successfully! Our concierge will contact you within 24 hours.');" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Full Name</label>
                            <input type="text" required class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm focus:ring-amber-500 focus:border-amber-500 text-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Email Address</label>
                            <input type="email" required class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm focus:ring-amber-500 focus:border-amber-500 text-gray-800 dark:text-white">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Inquiry Subject</label>
                            <input type="text" required class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm focus:ring-amber-500 focus:border-amber-500 text-gray-800 dark:text-white">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Your Message</label>
                            <textarea required rows="4" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm focus:ring-amber-500 focus:border-amber-500 text-gray-800 dark:text-white"></textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <button type="submit" class="w-full px-6 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition">Submit Inquiry</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-shop-layout>
