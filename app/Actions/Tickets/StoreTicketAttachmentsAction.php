<?php

namespace App\Actions\Tickets;

use App\Models\Attachment;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class StoreTicketAttachmentsAction
{
    private const DISK = 'local';

    /**
     * @param  array<int, UploadedFile>  $files
     * @return array<int, Attachment>
     */
    public function execute(
        Ticket $ticket,
        User $user,
        array $files,
        ?TicketComment $comment = null,
    ): array {
        $storedPaths = [];
        $attachments = [];

        try {
            foreach ($files as $file) {
                $path = $file->store("tickets/{$ticket->id}", self::DISK);
                $storedPaths[] = $path;

                $attachments[] = $ticket->attachments()->create([
                    'ticket_comment_id' => $comment?->id,
                    'user_id' => $user->id,
                    'disk' => self::DISK,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }

            return $attachments;
        } catch (Throwable $exception) {
            Storage::disk(self::DISK)->delete($storedPaths);

            throw $exception;
        }
    }
}
