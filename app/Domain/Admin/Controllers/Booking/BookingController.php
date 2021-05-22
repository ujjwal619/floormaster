<?php

namespace App\Domain\Admin\Controllers\Booking;

use App\Domain\Admin\Requests\Booking\BookingRequest;
use App\Domain\Admin\Services\Booking\BookingService;
use App\Domain\Admin\Services\Booking\BookingTypeService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

/**
 * Class BookingController
 * @package App\Domain\Admin\Controllers\Booking
 */
class BookingController extends AdminController
{
    /**
     * @var BookingTypeService
     */
    protected $bookingTypeService;

    /**
     * @var BookingService
     */
    protected $bookingService;

    /**
     * BookingController constructor.
     * @param BookingService $bookingService
     * @param BookingTypeService $bookingTypeService
     */
    public function __construct(BookingService $bookingService, BookingTypeService $bookingTypeService)
    {
        $this->bookingTypeService   = $bookingTypeService;
        $this->bookingService       = $bookingService;

        $this->middleware(['can:bookings.access']);
        $this->middleware('permission:bookings.add', ['only' => 'store']);
        $this->middleware('permission:bookings.edit', ['only' => ['update', 'delete']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // $bookingType            = $request->get('booking_type');
        // $latestBooking          = collect([]);
        // if ($this->bookingTypeService->findLatest()) {
        //     $latestBooking = $this->bookingTypeService->findLatest();
        // }
        // $selectedBookingType    = $bookingType ? $this->bookingTypeService->find($bookingType) : $latestBooking;
        // if ($bookingType ==  0) {
        //     $selectedBookingType = collect();
        // }
        $bookingTypes           = $this->bookingTypeService->getAll();
        // dd($bookingTypes);
        // $bookings               = $this->bookingService->getAll(!$selectedBookingType->count() ? null : $selectedBookingType->id);

        return view('admin.modules.booking.index', compact('bookingTypes'));
    }

    /**
     * @param BookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingRequest $request)
    {
        try {
            $this->bookingService->store($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new booking.', 'error');

            return $this->sendError('Unable to create new booking.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new booking.');
    }

    /**
     * @param int $id
     * @param BookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, BookingRequest $request)
    {
        try {
            $this->bookingService->update($id, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update booking.', 'error');

            return $this->sendError('Unable to update booking.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated booking.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->bookingService->delete($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Booking not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Booking.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully deleted booking.');
    }
}
