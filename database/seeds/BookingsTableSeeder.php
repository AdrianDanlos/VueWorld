<?php

use App\Booking;
use App\Bookable;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function(Bookable $bookable){
            $booking = factory(Booking::class)->make(); //Create a booking
            $bookings = collect([$booking]); //Creating a collection (instead of an array) and placing our booking inside

            for ($i=0; $i < random_int(1,20); $i++) { 
                $from = (clone $booking->to)->addDays(random_int(1, 14)); //We get the previous booking instance "end date" (to) and add random days until next reservation, so reservations won't ever overlap.
                $to = (clone $from)->addDays(random_int(1,14)); //We get the from we just created and add random days of stay.

                //We will create a new booking object and give it the "from" and "to" values we've just created. 
                // $booking = new Booking();
                // $booking->from = $from;
                // $booking->to = $to;

                //Instead of doing it on the begginers way we'll do it using Eloquent static methods, which is cleaner. For this mass assignment to work we had to enable it in the Booking model first.
                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to
                ]);

                //We push the booking into the collection of bookings.
                $bookings->push($booking);
            }

            //We save the bookings in our DB all at once
            $bookable->bookings()->saveMany($bookings);
        });
    }
}
