<?php

namespace App\Domain\Admin\Controllers\Booking;

use App\Domain\Admin\Requests\Booking\BookingTypeRequest;
use App\Domain\Admin\Services\Booking\BookingTypeService;
use App\StartUp\BaseClasses\Controller\AdminController;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class BookingTypeController
 * @package App\Domain\Admin\Controllers\Booking
 */
class BookingTypeController extends AdminController
{
    /**
     * @var BookingTypeService
     */
    protected $bookingTypeService;

    /**
     * BookingTypeController constructor.
     * @param BookingTypeService $bookingTypeService
     */
    public function __construct(BookingTypeService $bookingTypeService)
    {
        $this->bookingTypeService = $bookingTypeService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.modules.booking.index');
    }

    /**
     * @param int $id
     * @param BookingTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, BookingTypeRequest $request)
    {
        try {
            $this->bookingTypeService->update($id, $request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to update booking type.', 'error');

            return $this->sendError('Unable to update booking type.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully updated booking type.');
    }

    /**
     * @param BookingTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingTypeRequest $request)
    {
        try {
            $this->bookingTypeService->store($request->all());
        } catch (\Exception $exception) {
            logger()->error($exception);
            flash('Unable to create new booking type.', 'error');

            return $this->sendError('Unable to create new booking type.' . $exception, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully created new booking type.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $bookingType = $this->bookingTypeService->find($id);
            throw_if(!$bookingType, new ModelNotFoundException());

            throw_if($bookingType->bookings, new Exception('Could not delete. This type is used in bookings.'));
            
            $this->bookingTypeService->delete($id);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Booking type not found.', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());

            return $this->sendError('Unable to update Booking type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse([], 'Successfully deleted booking type.');
    }
}
