@include('email.header')

@php
    $email = $data['user_data'] ?? [];
    $details = $email['details'] ?? [];
@endphp

<tr>
    <td bgcolor="#ffffff" style="padding: 34px 30px 18px 30px; font-family: Arial, sans-serif; color: #1f2937;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 0 0 12px 0;">
                    <span style="display: inline-block; padding: 7px 12px; border-radius: 999px; background-color: {{ $email['status_color'] ?? '#FFBE42' }}; color: #ffffff; font-size: 12px; font-weight: bold; letter-spacing: .3px; text-transform: uppercase;">
                        {{ $email['status_label'] ?? ($details['status'] ?? 'Booking update') }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="font-size: 26px; line-height: 34px; font-weight: bold; color: #111827; padding: 0 0 10px 0;">
                    {{ $email['headline'] ?? 'Booking update' }}
                </td>
            </tr>
            <tr>
                <td style="font-size: 15px; line-height: 24px; color: #4b5563; padding: 0;">
                    Hi {{ $data['user']['name'] ?? 'there' }},
                    <br>
                    {{ $email['intro'] ?? 'There is an update to your booking.' }}
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
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                Booking Reference
                            </td>
                            <td align="right" style="font-size: 15px; line-height: 20px; color: #111827; font-family: Arial, sans-serif; font-weight: bold;">
                                {{ $details['booking_reference'] ?? 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding: 0 0 14px 0; font-size: 18px; line-height: 24px; color: #111827; font-family: Arial, sans-serif; font-weight: bold;">
                                {{ $details['service_title'] ?? 'Service' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="50%" valign="top" style="padding: 0 12px 12px 0; font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                            Category<br>
                                            <span style="font-size: 15px; color: #111827; font-weight: bold;">{{ $details['service_category'] ?? 'Service' }}</span>
                                        </td>
                                        <td width="50%" valign="top" style="padding: 0 0 12px 12px; font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                            Price<br>
                                            <span style="font-size: 15px; color: #111827; font-weight: bold;">{{ $details['service_price'] ?? 'Not available' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%" valign="top" style="padding: 0 12px 12px 0; font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                            Date<br>
                                            <span style="font-size: 15px; color: #111827; font-weight: bold;">{{ $details['schedule_date'] ?? 'Not scheduled' }}</span>
                                        </td>
                                        <td width="50%" valign="top" style="padding: 0 0 12px 12px; font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                            Time<br>
                                            <span style="font-size: 15px; color: #111827; font-weight: bold;">{{ $details['schedule_time'] ?? 'Not scheduled' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%" valign="top" style="padding: 0 12px 0 0; font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                            Requested<br>
                                            <span style="font-size: 15px; color: #111827; font-weight: bold;">{{ $details['requested_at'] ?? 'Not available' }}</span>
                                        </td>
                                        <td width="50%" valign="top" style="padding: 0 0 0 12px; font-size: 13px; line-height: 20px; color: #6b7280; font-family: Arial, sans-serif;">
                                            Status<br>
                                            <span style="font-size: 15px; color: #111827; font-weight: bold;">{{ $details['status'] ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff" style="padding: 0 30px 24px 30px; font-family: Arial, sans-serif;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="50%" valign="top" style="padding: 0 10px 0 0;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e5e7eb; border-radius: 8px;">
                        <tr>
                            <td style="padding: 16px 18px; border-bottom: 1px solid #e5e7eb; font-size: 15px; line-height: 22px; color: #111827; font-weight: bold; font-family: Arial, sans-serif;">
                                Customer Information
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 16px 18px; font-size: 13px; line-height: 21px; color: #6b7280; font-family: Arial, sans-serif;">
                                Name<br>
                                <span style="color: #111827; font-size: 14px;">{{ $details['customer_name'] ?? 'Customer' }}</span>
                                <br><br>
                                Email<br>
                                <span style="color: #111827; font-size: 14px;">{{ $details['customer_email'] ?? 'Not provided' }}</span>
                                <br><br>
                                Phone<br>
                                <span style="color: #111827; font-size: 14px;">{{ $details['customer_phone'] ?? 'Not provided' }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top" style="padding: 0 0 0 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e5e7eb; border-radius: 8px;">
                        <tr>
                            <td style="padding: 16px 18px; border-bottom: 1px solid #e5e7eb; font-size: 15px; line-height: 22px; color: #111827; font-weight: bold; font-family: Arial, sans-serif;">
                                Provider Information
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 16px 18px; font-size: 13px; line-height: 21px; color: #6b7280; font-family: Arial, sans-serif;">
                                Name<br>
                                <span style="color: #111827; font-size: 14px;">{{ $details['provider_name'] ?? 'Provider' }}</span>
                                <br><br>
                                Email<br>
                                <span style="color: #111827; font-size: 14px;">{{ $details['provider_email'] ?? 'Not provided' }}</span>
                                <br><br>
                                Phone<br>
                                <span style="color: #111827; font-size: 14px;">{{ $details['provider_phone'] ?? 'Not provided' }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff" style="padding: 0 30px 28px 30px; font-family: Arial, sans-serif;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e5e7eb; border-radius: 8px;">
            <tr>
                <td style="padding: 18px 20px; font-size: 13px; line-height: 21px; color: #6b7280; font-family: Arial, sans-serif;">
                    Service Address<br>
                    <span style="color: #111827; font-size: 14px;">{{ $details['customer_address'] ?? 'Not provided' }}</span>
                    <br><br>
                    Booking Notes<br>
                    <span style="color: #111827; font-size: 14px;">{{ $details['booking_notes'] ?? 'No notes provided' }}</span>
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
        {{ $email['footer_note'] ?? 'You can review this booking from your Servease account.' }}
        @if(!empty($email['support_email']))
            <br>
            Need help? Contact {{ $email['support_email'] }}.
        @endif
    </td>
</tr>

@include('email.footer')
