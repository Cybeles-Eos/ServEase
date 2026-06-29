@include('email.header')

<tr>
    <td align="center" bgcolor="#ffffff"
        style="padding: 40px 25px 25px 25px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f0f0f0;">

        <b>Hi {{ $data['user']['name'] ?? 'there' }},</b>
        <br>
        <span>You requested to reset your Servease password.</span>
    </td>
</tr>

<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 35px 20px; color: #555555; font-family: Arial, sans-serif;">

        <p style="font-size: 16px; line-height: 24px; margin: 0 0 15px 0;">
            Use the OTP code below to reset your password.
        </p>

        <div style="margin: 25px 0; padding: 22px; background-color: #ffffff; border: 1px solid #eeeeee; border-radius: 8px;">
            <p style="margin: 0 0 10px 0; font-size: 14px; color: #777777;">
                Your password reset code is:
            </p>

            <p style="margin: 0; font-size: 36px; line-height: 44px; letter-spacing: 8px; font-weight: bold; color: #FFBE42;">
                {{ $data['otp'] ?? '' }}
            </p>
        </div>

        <p style="font-size: 14px; line-height: 22px; color: #777777; margin: 0;">
            This OTP will expire in {{ $data['expires_in'] ?? 10 }} minutes.
        </p>

        <p style="font-size: 14px; line-height: 22px; color: #777777; margin: 15px 0 0 0;">
            If you did not request a password reset, you can ignore this email.
        </p>
    </td>
</tr>

@include('email.footer')