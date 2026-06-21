<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AdminPasswordResetNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);
        $minutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject('Redefinição de senha do painel administrativo')
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Recebemos uma solicitação para redefinir a senha da sua conta administrativa.')
            ->action('Criar nova senha', $url)
            ->line("Este link expira em {$minutes} minutos.")
            ->line('Se você não solicitou a redefinição, ignore este e-mail. Sua senha permanecerá inalterada.')
            ->salutation('Equipe Conselho Tutelar');
    }
}
