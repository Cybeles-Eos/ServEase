@include('email.header')

@php
    $payload = $data['user_data'] ?? [];
    $request = $payload['request'] ?? [];
    $customer = $payload['customer'] ?? [];
@endphp

<tr>
    <td bgcolor="#ffffff" style="padding: 34px 30px 18px 30px; font-family: Arial, sans-serif; color: #1f2937;">
        <span style="display: inline-block; padding: 7px 12px; border-radius: 999px; background-color: #22C55E; color: #ffffff; font-size: 12px; font-weight: bold; letter-spacing: .3px; text-transform: uppercase;">
            Accepted
        </span>
        <h1 style="margin: 14px 0 8px; font-size: 26px; line-height: 34px; color: #111827;">
            {{ $payload['headline'] ?? 'Customer request accepted' }}
        </h1>
        <p style="margin: 0; font-size: 15px; line-height: 24px; color: #4b5563;">
            Hi {{ $data['user']['name'] ?? 'there' }}, the customer selected you for this request. Contact the customer directly to finalize details.
        </p>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff" style="padding: 0 30px 24px 30px; font-family: Arial, sans-serif;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e5e7eb; border-radius: 8px;">
            <tr>
                <td style="padding: 18px 20px; font-size: 13px; line-height: 21px; color: #6b7280;">
                    Request Reference<br>
                    <strong style="color:#111827; font-size: 15px;">{{ $request['reference'] ?? 'N/A' }}</strong>
                    <br><br>
                    Request Title<br>
                    <strong style="color:#111827; font-size: 18px;">{{ $request['title'] ?? 'Customer Request' }}</strong>
                    <br><br>
                    Fixed Price<br>
                    <strong style="color:#111827; font-size: 15px;">{{ $request['fixed_price'] ?? 'Not provided' }}</strong>
                    <br><br>
                    Service Type<br>
                    <strong style="color:#111827; font-size: 15px;">{{ $request['service_type'] ?? 'Custom service' }}</strong>
                    <br><br>
                    Description<br>
                    <span style="color:#111827; font-size: 14px;">{{ $request['description'] ?? 'No description provided' }}</span>
                    <br><br>
                    Your Notes<br>
                    <span style="color:#111827; font-size: 14px;">{{ $request['notes'] ?? 'No notes provided' }}</span>
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff" style="padding: 0 30px 24px 30px; font-family: Arial, sans-serif;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e5e7eb; border-radius: 8px;">
            <tr>
                <td style="padding: 18px 20px; font-size: 13px; line-height: 21px; color: #6b7280;">
                    Customer Name<br>
                    <span style="color:#111827; font-size: 14px;">{{ $customer['name'] ?? 'Customer' }}</span>
                    <br><br>
                    Email<br>
                    <span style="color:#111827; font-size: 14px;">{{ $customer['email'] ?? 'Not provided' }}</span>
                    <br><br>
                    Phone<br>
                    <span style="color:#111827; font-size: 14px;">{{ $customer['phone'] ?? 'Not provided' }}</span>
                    <br><br>
                    Address<br>
                    <span style="color:#111827; font-size: 14px;">{{ $customer['address'] ?? 'Not provided' }}</span>
                </td>
            </tr>
        </table>
    </td>
</tr>

@if(!empty($request['image_url']))
    <tr>
        <td bgcolor="#ffffff" style="padding: 0 30px 24px 30px;">
            <img src="{{ $request['image_url'] }}" alt="{{ $request['title'] ?? 'Customer request image' }}" style="display:block; width:100%; max-width:540px; border-radius:8px;">
        </td>
    </tr>
@endif

@if(!empty($payload['cta_url']) && !empty($payload['cta_label']))
    <tr>
        <td align="center" bgcolor="#ffffff" style="padding: 0 30px 34px 30px; font-family: Arial, sans-serif;">
            <a href="{{ $payload['cta_url'] }}" style="display: inline-block; background-color: #FFBE42; color: #111827; text-decoration: none; padding: 13px 22px; border-radius: 6px; font-size: 14px; line-height: 18px; font-weight: bold;">
                {{ $payload['cta_label'] }}
            </a>
        </td>
    </tr>
@endif

@include('email.footer')
