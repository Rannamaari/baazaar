<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');
        
        $this->info("Testing email configuration...");
        $this->info("Sending test email to: {$email}");
        
        try {
            Mail::raw('This is a test email from Baazaar. If you received this, your email configuration is working correctly!', function (Message $message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - Baazaar Email Configuration');
            });
            
            $this->info("✅ Test email sent successfully!");
            $this->info("Please check the inbox for: {$email}");
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email:");
            $this->error($e->getMessage());
        }
    }
}
