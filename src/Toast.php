<?php

namespace Nubix\Toast;

use Exception;
use Illuminate\Session\Store;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Toast
{
    public const SUCCESS = 'success';

    public const INFO = 'info';

    public const WARNING = 'warning';

    public const DANGER = 'danger';

    protected Store $session;

    public Collection $messages;

    /**
     * Toast constructor.
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
        $this->messages = collect();
    }

    public function message(string|array $message, string $level = self::INFO, ?string $id = null) : static
    {
        $newMsg = new Message($message);

        if (is_array($message)) {
            $newMsg->id = Arr::get($message, 'id', Str::uuid());
            $newMsg->type = Arr::get($message, 'type', self::INFO);
        } else {
            $newMsg->id = $id ?? Str::uuid();
            $newMsg->type = $level;
        }

        $this->messages->push($newMsg);
        return $this->toast();
    }

    public function toast() : static
    {
        $this->session->flash(config('toast.session_id'), $this->messages->toArray());

        return $this;
    }

    public function get(?int $index = null) : Message
    {
        $messages = $this->session->get(config('toast.session_id'));
        return isset($index) ?
            $messages[$index] : $messages;
    }

    /**
     * @throws Exception
     */
    protected function updateLastMessage(array $overrides = []) : static
    {
        if (! $this->messages->isEmpty()) {
            $this->messages->last()->update($overrides);
            return $this;
        }

        if (! Arr::exists($overrides, 'body')) {
            throw new Exception('Missing message body');
        }

        $this->message($overrides);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function info(?string $message = null) : static
    {
        if (! isset($message)) {
            return $this->updateLastMessage(['type' => static::INFO]);
        }

        return $this->message($message, self::INFO);
    }

    /**
     * @throws Exception
     */
    public function warning(?string $message = null) : static
    {
        if (! isset($message)) {
            return $this->updateLastMessage(['type' => static::WARNING]);
        }

        return $this->message($message, self::WARNING);
    }

    /**
     * @throws Exception
     */
    public function success(?string $message = null) : static
    {
        if (! isset($message)) {
            return $this->updateLastMessage(['type' => static::SUCCESS]);
        }

        return $this->message($message, self::SUCCESS);
    }

    /**
     * @throws Exception
     */
    public function danger(?string $message = null) : static
    {
        if (! isset($message)) {
            return $this->updateLastMessage(['type' => static::DANGER]);
        }

        return $this->message($message, self::DANGER);
    }

    /**
     * @throws Exception
     */
    public function important() : static
    {
        return $this->updateLastMessage(['important' => true]);
    }

    /**
     * @throws Exception
     */
    public function title(string $title) : static
    {
        return $this->updateLastMessage(['title' => $title]);
    }

    /**
     * @throws Exception
     */
    public function id(string $id) : static
    {
        return $this->updateLastMessage(['id' => $id]);
    }

    /**
     * @throws Exception
     */
    public function timeout(string $timeout) : static
    {
        return $this->updateLastMessage(['timeout' => $timeout]);
    }

    /**
     * @throws Exception
     */
    public function type(string $type) : static
    {
        return $this->updateLastMessage(['type' => $type]);
    }

    public function clear() : static
    {
        $this->messages = collect();

        return $this;
    }
}
