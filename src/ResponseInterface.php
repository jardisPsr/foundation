<?php

declare(strict_types=1);

namespace JardisPort\Foundation;

/**
 * Interface for Domain Response objects.
 *
 * Defines the contract for collecting results across bounded context calls.
 */
interface ResponseInterface
{
    /**
     * Get the context (BC/Use-Case name) of this response.
     */
    public function getContext(): string;

    /**
     * Add a single data entry.
     */
    public function addData(string $key, mixed $value): self;

    /**
     * Set all data at once (replaces existing data).
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): self;

    /**
     * Get data from this response only (non-recursive).
     *
     * @return array<string, mixed>
     */
    public function getData(): array;

    /**
     * Get all data including sub-responses (recursive).
     *
     * @return array<string, array<string, mixed>>
     */
    public function getAllData(): array;

    /**
     * Add a domain event.
     */
    public function addEvent(object $event): self;

    /**
     * Get events from this response only (non-recursive).
     *
     * @return array<int, object>
     */
    public function getEvents(): array;

    /**
     * Get all events including sub-responses (recursive).
     *
     * @return array<int, object>
     */
    public function getAllEvents(): array;

    /**
     * Add an error message.
     */
    public function addError(string $message): self;

    /**
     * Get errors from this response only (non-recursive).
     *
     * @return array<int, string>
     */
    public function getErrors(): array;

    /**
     * Get all errors, including sub-responses (recursive).
     *
     * @return array<string, array<int, string>>
     */
    public function getAllErrors(): array;

    /**
     * Check if this response has errors (non-recursive).
     */
    public function hasErrors(): bool;

    /**
     * Add a sub-response from a nested BC call.
     */
    public function addResponse(ResponseInterface $response): self;

    /**
     * Get direct sub-responses (non-recursive).
     *
     * @return array<int, ResponseInterface>
     */
    public function getResponses(): array;

    /**
     * Check if this response and all sub-responses are successful (no errors).
     */
    public function isSuccess(): bool;

    /**
     * Get metadata summary for this response (non-recursive).
     *
     * @return array<string, mixed>
     */
    public function getMetadata(): array;

    /**
     * Get metadata for all responses, including sub-responses (recursive).
     *
     * @return array<string, array<string, mixed>>
     */
    public function getAllMetadata(): array;
}
