<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">

    <title>Restablece tu contraseña - ZendTicket</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f9fafb; font-family: Arial, Helvetica, sans-serif; color: #1f2937;">

    <!-- Contenedor exterior -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
        style="width: 100%; margin: 0; padding: 0; background-color: #f9fafb;">
        <tr>
            <td align="center" style="padding: 48px 16px;">

                <!-- Tarjeta principal -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="width: 100%; max-width: 600px; background-color: #ffffff; border: 1px solid #f3f4f6; border-radius: 24px; overflow: hidden;">

                    <!-- Encabezado -->
                    <tr>
                        <td align="center"
                            style="padding: 36px 32px; background-color: #059669; border-radius: 24px 24px 0 0;">

                            <!-- Icono -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                style="margin: 0 auto 12px auto;">
                                <tr>
                                    <td align="center" valign="middle" width="44" height="44"
                                        style="width: 44px; height: 44px; background-color: #ffffff; border-radius: 12px; color: #059669; font-size: 22px; font-weight: bold;">
                                        ✓
                                    </td>
                                </tr>
                            </table>

                            <div
                                style="margin: 0; color: #ffffff; font-size: 26px; line-height: 32px; font-weight: 700;">
                                Zend<span style="color: #a7f3d0;">Ticket</span>
                            </div>

                            <div
                                style="margin-top: 4px; color: #d1fae5; font-size: 11px; line-height: 16px; font-weight: 600; letter-spacing: 1.5px;">
                                SUPPORT SYSTEM
                            </div>
                        </td>
                    </tr>

                    <!-- Contenido -->
                    <tr>
                        <td style="padding: 40px 32px;">

                            <p
                                style="margin: 0 0 8px 0; color: #10b981; font-size: 12px; line-height: 18px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
                                Solicitud de cuenta
                            </p>

                            <h1
                                style="margin: 0 0 24px 0; color: #111827; font-size: 22px; line-height: 30px; font-weight: 700;">
                                Hola, {{ $name }}
                            </h1>

                            <p style="margin: 0 0 16px 0; color: #4b5563; font-size: 15px; line-height: 24px;">
                                Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en ZendTicket.
                            </p>

                            <p style="margin: 0 0 28px 0; color: #4b5563; font-size: 15px; line-height: 24px;">
                                Si realizaste esta solicitud, utiliza el siguiente botón para crear una nueva
                                contraseña.
                            </p>

                            <!-- Botón -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"
                                style="margin: 0 auto 28px auto;">
                                <tr>
                                    <td align="center" bgcolor="#22c55e"
                                        style="background-color: #22c55e; border-radius: 12px;">
                                        <a href="{{ $url }}" target="_blank"
                                            style="display: inline-block; padding: 15px 28px; color: #ffffff; font-size: 14px; line-height: 18px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 12px;">
                                            Restablecer contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Expiración -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="width: 100%; margin-bottom: 20px; background-color: #ecfdf5; border: 1px solid #d1fae5; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 16px; color: #047857; font-size: 13px; line-height: 20px;">
                                        <strong>Importante:</strong>
                                        este enlace estará disponible durante {{ $expires }} minutos.
                                    </td>
                                </tr>
                            </table>

                            <!-- Aviso de seguridad -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="width: 100%; margin-bottom: 28px; background-color: #f8fafc; border: 1px solid #f3f4f6; border-radius: 12px;">
                                <tr>
                                    <td style="padding: 16px; color: #6b7280; font-size: 13px; line-height: 20px;">
                                        <strong style="color: #374151;">¿No solicitaste este cambio?</strong>
                                        Si no realizaste esta solicitud, puedes ignorar este correo.
                                        Tu contraseña actual seguirá funcionando sin modificaciones.
                                    </td>
                                </tr>
                            </table>

                            <!-- Separador -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td
                                        style="height: 1px; background-color: #f3f4f6; font-size: 1px; line-height: 1px;">
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>

                            <!-- URL alternativa -->
                            <p
                                style="margin: 28px 0 8px 0; color: #9ca3af; font-size: 11px; line-height: 18px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">
                                ¿El botón no funciona?
                            </p>

                            <p style="margin: 0 0 12px 0; color: #6b7280; font-size: 12px; line-height: 19px;">
                                Copia y pega el siguiente enlace en tu navegador:
                            </p>

                            <p
                                style="margin: 0; padding: 14px; background-color: #f8fafc; border: 1px solid #f3f4f6; border-radius: 10px; font-size: 12px; line-height: 18px; word-break: break-all;">
                                <a href="{{ $url }}" target="_blank"
                                    style="color: #059669; text-decoration: none;">
                                    {{ $url }}
                                </a>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding: 24px 32px; background-color: #111827; border-radius: 0 0 24px 24px;">

                            <p style="margin: 0 0 6px 0; color: #9ca3af; font-size: 12px; line-height: 18px;">
                                &copy; {{ date('Y') }} ZendTicket. Todos los derechos reservados.
                            </p>

                            <p style="margin: 0; color: #6b7280; font-size: 10px; line-height: 16px;">
                                Este es un mensaje automático. Por favor, no respondas a este correo.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
