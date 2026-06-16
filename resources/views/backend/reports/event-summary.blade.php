<!DOCTYPE html>
<html>
<head>
    <title>Event Invitation - {{ $event->event_name }}</title>
    <style>
        /* Base Styling & Card Framing */
        body { font-family: 'Georgia', 'Times New Roman', serif; color: #2c3e50; font-size: 13px; line-height: 1.6; margin: 0; padding: 30px; background-color: #ffffff; }
        .invitation-card { border: 1px solid #d4af37; padding: 40px; background-color: #fdfbf7; border-radius: 4px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative; }
        
        /* Ornamental Details */
        .corner-border { position: absolute; border: 2px solid #d4af37; width: 20px; height: 20px; }
        .top-left { top: 15px; left: 15px; border-right: none; border-bottom: none; }
        .top-right { top: 15px; right: 15px; border-left: none; border-bottom: none; }
        .bottom-left { bottom: 15px; left: 15px; border-right: none; border-top: none; }
        .bottom-right { bottom: 15px; right: 15px; border-left: none; border-top: none; }

        /* Typography & Header */
        .badge-container { text-align: center; margin-bottom: 10px; }
        .invitation-badge { display: inline-block; font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; background-color: #d4af37; color: white; padding: 4px 12px; font-weight: bold; border-radius: 20px; }
        .header { text-align: center; margin-bottom: 35px; padding-bottom: 20px; border-bottom: 1px dashed #d4af37; }
        .main-title { font-size: 28px; font-weight: normal; color: #1a365d; margin: 10px 0 5px 0; font-style: italic; }
        .sub-title { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; letter-spacing: 1px; color: #718096; text-transform: uppercase; margin: 0; }
        
        /* Content Block Structure */
        .section-title { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; font-weight: bold; color: #d4af37; letter-spacing: 1px; text-transform: uppercase; margin-top: 30px; margin-bottom: 15px; text-align: center; }
        .divider { height: 1px; width: 50px; background-color: #d4af37; margin: 5px auto 15px auto; }

        /* Core Details Presentation Grid */
        .details-grid { width: 100%; margin: 0 auto 25px auto; border-collapse: collapse; }
        .details-grid td { padding: 12px 15px; vertical-align: middle; border-bottom: 1px solid #f0e6d2; }
        .details-grid tr:last-child td { border-bottom: none; }
        .label { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; font-weight: bold; color: #718096; text-transform: uppercase; width: 30%; letter-spacing: 0.5px; }
        .value { font-size: 14px; color: #2d3748; font-weight: 500; }
        
        /* Narrative Box Layout */
        .narrative-container { background: #fffdf9; border: 1px solid #f0e6d2; padding: 20px; text-align: center; font-style: italic; color: #4a5568; font-size: 13px; border-radius: 4px; line-height: 1.8; }

        /* Roster Grid Formatting */
        .guest-table { width: 100%; border-collapse: collapse; margin-top: 10px; background-color: #ffffff; border: 1px solid #f0e6d2; }
        .guest-table th { font-family: 'Helvetica', Arial, sans-serif; background-color: #1a365d; color: #ffffff; padding: 10px; font-size: 10px; font-weight: bold; text-align: left; text-transform: uppercase; letter-spacing: 0.5px; }
        .guest-table td { padding: 10px; border-bottom: 1px solid #f0e6d2; font-size: 12px; color: #4a5568; }
        .guest-table tr:nth-child(even) td { background-color: #fdfbf7; }
        .guest-count { font-family: 'Helvetica', Arial, sans-serif; font-size: 10px; color: #a0aec0; text-align: right; margin-top: 8px; text-transform: uppercase; }
    </style>
</head>
<body>

    <div class="invitation-card">
        <!-- Decorative Border Corners -->
        <div class="corner-border top-left"></div>
        <div class="corner-border top-right"></div>
        <div class="corner-border bottom-left"></div>
        <div class="corner-border bottom-right"></div>

        <!-- Elegant Heading Banner Header Block -->
        <div class="badge-container">
            <span class="invitation-badge">{{ $event->status }}</span>
        </div>
        <div class="header">
            <h1 class="main-title">{{ $event->event_name }}</h1>
            <p class="sub-title">Official Event Brief & Roster Profile</p>
            <small style="color: #a0aec0; font-size: 10px; font-family: Arial;">Ref ID: EVT-00{{ $event->id }}</small>
        </div>

        <!-- Specifications Layout -->
        <div class="section-title">Event Schedule & Parameters</div>
        <div class="divider"></div>
        
        <table class="details-grid">
            <tr>
                <td class="label">Classification Type</td>
                <td class="value">{{ $event->event_type ?? 'Special Event' }}</td>
            </tr>
            <tr>
                <td class="label">Date & Timing</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('l, F d, Y') }}
                    @if($event->event_time) at {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }} @endif
                </td>
            </tr>
            <tr>
                <td class="label">Venue Location</td>
                <td class="value" style="color: #1a365d;">{{ $event->event_location ?? 'To Be Announced' }}</td>
            </tr>
        </table>

        <!-- Description Box Layout -->
        <div class="section-title">An Overview Context</div>
        <div class="divider"></div>
        <div class="narrative-container">
            “ {{ $event->description ?? 'No specific parameters or narrative summaries have been published for this invitation card index log.' }} ”
        </div>

        <!-- Attending Guest List Array Layout Block -->
        <div class="section-title">Confirmed Guest Attendance</div>
        <div class="divider"></div>
        
        <table class="guest-table">
            <thead>
                <tr>
                    <th style="width: 8%; text-align: center;">#</th>
                    <th style="width: 37%;">Guest Full Name</th>
                    <th style="width: 35%;">Email Address</th>
                    <th style="width: 20%;">Contact Number</th>
                </tr>
            </thead>
            <tbody>
                @forelse($event->participants as $index => $participant)
                <tr>
                    <td style="text-align: center; color: #a0aec0;">{{ $index + 1 }}</td>
                    <td><strong>{{ $participant->full_name }}</strong></td>
                    <td style="font-family: Arial, sans-serif; font-size: 11px;">{{ $participant->email }}</td>
                    <td style="font-family: Arial, sans-serif; font-size: 11px;">{{ $participant->phone ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #a0aec0; padding: 20px; font-style: italic;">No registered guest allocations matched inside this query context filter.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($event->participants->count() > 0)
            <div class="guest-count">Total Confirmed Attendees: {{ $event->participants->count() }}</div>
        @endif
    </div>

</body>
</html>
