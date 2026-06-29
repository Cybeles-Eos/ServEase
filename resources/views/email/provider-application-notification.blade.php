@include('email.header')

@php
    $email = $data['user_data'] ?? [];
    $provider = $email['provider'] ?? [];
    $requiredDocuments = $provider['required_documents'] ?? [];
@endphp

<tr>
    <td bgcolor="#ffffff" style="padding: 34px 30px 18px 30px; font-family: Arial, sans-serif; color: #1f2937;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 0 0 12px 0;">
                    <span style="display: inline-block; padding: 7px 12px; border-radius: 999px; background-color: {{ $email['status_color'] ?? '#FFBE42' }}; color: #ffffff; font-size: 12px; font-weight: bold; letter-spacing: .3px; text-transform: uppercase;">
                        {{ $email['status_label'] ?? 'Application update' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="font-size: 26px; line-height: 34px; font-weight: bold; color: #111827; padding: 0 0 10px 0;">
                    {{ $email['headline'] ?? 'Provider application update' }}
                </td>
            </tr>
            <tr>
                <td style="font-size: 15px; line-height: 24px; color: #4b5563; padding: 0;">
                    Hi {{ $data['user']['name'] ?? 'there' }},
                    <br>
                    {{ $email['intro'] ?? 'There is an update to your provider application.' }}
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff" style="padding: 0 30px 24px 30px; font-family: Arial, sans-serif;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: separate; border-spacing: 0; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
            <tr>
                <td bgcolor="#f9fafb" style="padding: 18px 20px; border-bottom: 1px solid #e5e7eb;">
                    <strong style="font-size: 16px; line-height: 22px; color: #111827;">Application Details</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 18px 20px; font-size: 13px; line-height: 21px; color: #6b7280;">
                    Provider<br>
                    <span style="color: #111827; font-size: 14px;">{{ $provider['name'] ?? 'Provider' }}</span>
                    <br><br>
                    Profession<br>
                    <span style="color: #111827; font-size: 14px;">{{ $provider['profession'] ?? 'Service provider' }}</span>
                    @if(!empty($provider['remarks']))
                        <br><br>
                        Remarks<br>
                        <span style="color: #111827; font-size: 14px;">{{ $provider['remarks'] }}</span>
                    @endif
                    @if(!empty($requiredDocuments))
                        <br><br>
                        Requested document{{ count($requiredDocuments) > 1 ? 's' : '' }}<br>
                        <span style="color: #111827; font-size: 14px;">{{ implode(', ', $requiredDocuments) }}</span>
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>

@if(!empty($email['cta_url']) && !empty($email['cta_label']))
    <tr>
        <td align="center" bgcolor="#ffffff" style="padding: 0 30px 30px 30px; font-family: Arial, sans-serif;">
            <a href="{{ $email['cta_url'] }}" style="display: inline-block; background-color: #FFBE42; color: #111827; text-decoration: none; padding: 13px 22px; border-radius: 6px; font-size: 14px; line-height: 18px; font-weight: bold;">
                {{ $email['cta_label'] }}
            </a>
        </td>
    </tr>
@endif

<tr>
    <td bgcolor="#ffffff" style="padding: 0 30px 34px 30px; color: #6b7280; font-family: Arial, sans-serif; font-size: 13px; line-height: 21px;">
        {{ $email['footer_note'] ?? 'Login to your Servease account to review this update.' }}
        @if(!empty($email['support_email']))
            <br>
            Need help? Contact {{ $email['support_email'] }}.
        @endif
    </td>
</tr>

@include('email.footer')
