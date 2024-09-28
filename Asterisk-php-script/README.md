# Asterisk-php-script
 Asterisk PHP script to make calls automatically.

This is an Asterisk PHP script that look for an outbound message (That you must configure in extensions.conf) and call a list of phones (Should have the asterisk in conditions).
The outbound message is the one who do the trick.

This one, for example, can detect if the phone is picked up by an user or a machine and wait for silence in case it detects a machine:

[outboundmsg1]
exten => s,1,Set(TIMEOUT(digit)=5)             ; Set Digit Timeout to 5 seconds
exten => s,2,Set(TIMEOUT(response)=30)         ; Set Response Timeout to 10 seconds
exten => s,3,Answer
exten => s,4,Wait(1)
exten => s,5,AMD()
exten => s,6,GotoIf($["${AMDSTATUS}" = "HUMAN"]?human:machine)
exten => s,7(machine),WaitForSilence(2000)
exten => s,8,Noop(MAQUINA EN LINEA)
exten => s,9,Background(JingleSinatra2)         ; "play outbound msg"
exten => t,2,Hangup
exten => s,10(human),Verbose(3, HUMANO EN LINEA)
exten => s,11,Background(JingleSinatra2)
; exten => s,5,Playback(./custom/audio4)
exten => t,2,Hangup

The PHP script ONLY create the call file in order for this to reproduce.

I have other outbound messages that can detect if numbers are pressed, won't upload them, but send me a message if you need it.

Use it at your convenience :), <b>I am not responsible for the missuse of this script</b>