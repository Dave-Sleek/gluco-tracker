<h2 style="color: #0d6efd;">New Contact Form Submission</h2>

<table style="width: 100%; font-family: Arial, sans-serif; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; padding: 8px;">Name:</td>
        <td style="padding: 8px;">{{ $data['name'] }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 8px;">Email:</td>
        <td style="padding: 8px;">{{ $data['email'] }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 8px;">Message:</td>
        <td style="padding: 8px;">{{ $data['message'] }}</td>
    </tr>
</table>
