<?php

namespace Modules\Core\Traits;

use Masmerise\Toaster\Toastable;

trait NotifiesWithToast {
    use Toastable;

    protected function notifySuccess(string $message): void {
        $this->success($message);
    }

    protected function notifyWarning(string $message): void {
        $this->warning($message);
    }

    protected function notifyError(string $message): void {
        $this->error($message);
    }

    protected function notifyInfo(string $message): void {
        $this->info($message);
    }


    protected function notifySaved(): void {
        $this->success(__('core::shared.alerts.saved'));
    }

    protected function notifyCreated(): void {
        $this->success(__('core::shared.alerts.created'));
    }

    protected function notifyUpdated(): void {
        $this->success(__('core::shared.alerts.updated'));
    }

    protected function notifyDeleted(): void {
        $this->success(__('core::shared.alerts.deleted'));
    }


    protected function notifyUnauthorized(): void {
        $this->error(__('core::shared.alerts.unauthorized'));
    }

    protected function notifyForbidden(): void {
        $this->error(__('core::shared.alerts.forbidden'));
    }

    protected function notifySomethingWentWrong(): void {
        $this->error(__('core::shared.alerts.something_went_wrong'));
    }
}
