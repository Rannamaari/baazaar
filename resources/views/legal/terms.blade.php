<x-app-layout>
    <x-slot name="title">Terms & Conditions - Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Read Baazaar Maldives Terms & Conditions. Learn about our policies for orders, payments, delivery, returns, user accounts and service usage. COD and bank transfer payment options available.</x-slot>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            Terms & Conditions
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-slate-900">
                    
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-600 mb-6">
                            <strong>Last updated:</strong> {{ date('F d, Y') }}
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">1. Acceptance of Terms</h3>
                        <p class="mb-6">
                            By accessing and using Baazaar ("the Service"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">2. Use License</h3>
                        <p class="mb-4">
                            Permission is granted to temporarily download one copy of Baazaar for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                        </p>
                        <ul class="list-disc pl-6 mb-6 space-y-2">
                            <li>modify or copy the materials</li>
                            <li>use the materials for any commercial purpose or for any public display</li>
                            <li>attempt to reverse engineer any software contained on Baazaar's website</li>
                            <li>remove any copyright or other proprietary notations from the materials</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">3. User Accounts</h3>
                        <p class="mb-4">
                            When you create an account with us, you must provide information that is accurate, complete, and current at all times. You are responsible for safeguarding the password and for all activities that occur under your account.
                        </p>
                        <p class="mb-6">
                            You may not use as a username the name of another person or entity or that is not lawfully available for use, a name or trademark that is subject to any rights of another person or entity other than you without appropriate authorization, or a name that is otherwise offensive, vulgar or obscene.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">4. Product Information</h3>
                        <p class="mb-4">
                            We strive to provide accurate product descriptions, images, and pricing. However, we do not warrant that product descriptions or other content is accurate, complete, reliable, current, or error-free.
                        </p>
                        <p class="mb-6">
                            Product images are for illustrative purposes only and may not reflect the exact appearance of the product. Colors may vary depending on your device's display settings.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">5. Orders and Payment</h3>
                        <p class="mb-4">
                            All orders are subject to acceptance by Baazaar. We reserve the right to refuse or cancel your order at any time for certain reasons including but not limited to:
                        </p>
                        <ul class="list-disc pl-6 mb-4 space-y-2">
                            <li>Product or service availability</li>
                            <li>Errors in the description or price of the product or service</li>
                            <li>Error in your order or other reasons</li>
                        </ul>
                        <p class="mb-6">
                            We accept payment through Cash on Delivery (COD), Bank Transfer, and Card payments. For bank transfers, payment slips must be uploaded for verification.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">6. Delivery</h3>
                        <p class="mb-4">
                            We deliver across the Maldives. Delivery times may vary depending on your location and product availability. We will provide estimated delivery times during checkout.
                        </p>
                        <p class="mb-6">
                            You are responsible for providing accurate delivery addresses. We are not liable for delays or failed deliveries due to incorrect address information.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">7. Returns and Refunds</h3>
                        <p class="mb-4">
                            Please refer to our <a href="{{ route('legal.refunds') }}" class="text-blue-600 hover:text-blue-700 underline">Refund Policy</a> for detailed information about returns and refunds.
                        </p>
                        <p class="mb-6">
                            Generally, returns are accepted within 7 days of delivery for unused items in original packaging.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">8. Privacy Policy</h3>
                        <p class="mb-6">
                            Your privacy is important to us. Please review our <a href="{{ route('legal.privacy') }}" class="text-blue-600 hover:text-blue-700 underline">Privacy Policy</a>, which also governs your use of the Service.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">9. Prohibited Uses</h3>
                        <p class="mb-4">
                            You may not use our Service:
                        </p>
                        <ul class="list-disc pl-6 mb-6 space-y-2">
                            <li>For any unlawful purpose or to solicit others to perform unlawful acts</li>
                            <li>To violate any international, federal, provincial, or state regulations, rules, laws, or local ordinances</li>
                            <li>To infringe upon or violate our intellectual property rights or the intellectual property rights of others</li>
                            <li>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate</li>
                            <li>To submit false or misleading information</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">10. Limitation of Liability</h3>
                        <p class="mb-6">
                            In no event shall Baazaar, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your use of the Service.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">11. Governing Law</h3>
                        <p class="mb-6">
                            These Terms shall be interpreted and governed by the laws of the Republic of Maldives, without regard to its conflict of law provisions.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">12. Changes to Terms</h3>
                        <p class="mb-6">
                            We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days notice prior to any new terms taking effect.
                        </p>

                        <h3 class="text-xl font-semibold text-slate-800 mb-4">13. Contact Information</h3>
                        <p class="mb-6">
                            If you have any questions about these Terms & Conditions, please contact us at:
                        </p>
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <p><strong>Email:</strong> support@baazaar.mv</p>
                            <p><strong>Phone:</strong> +960 XXX-XXXX</p>
                            <p><strong>Address:</strong> Malé, Maldives</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
