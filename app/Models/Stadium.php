<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
	public static function stadiums(): array
	{
		return [
			[
				'name' => 'Arrowhead Stadium',
				'key' => 'arrowhead',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Arrowhead%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9BcnJvd2hlYWQgU3RhZGl1bS5wbmciLCJpYXQiOjE3NDAzMzExNjksImV4cCI6MTgwMzQwMzE2OX0.JTxEGm05xr4HGOiNZklA8jYEeFK8CNIowp4W-sLNbbo'
			],
			[
				'name' => 'AT&T Stadium',
				'key' => 'att',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/AT&T%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9BVCZUIFN0YWRpdW0ucG5nIiwiaWF0IjoxNzQwMzMxMTgzLCJleHAiOjE4MDM0MDMxODN9.pomKCip1KMvliLg133R8hp9x4bccvPtoNKWIgUmTumY'
			],
			[
				'name' => 'BC Place',
				'key' => 'bc',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/BC%20Place.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9CQyBQbGFjZS5wbmciLCJpYXQiOjE3NDAzMzExOTksImV4cCI6MTgwMzQwMzE5OX0.X1MHGPMPMiEygUQKviAz1dwHzdLYNuEDiCzSDx4difw'
			],
			[
				'name' => 'BMO Field',
				'key' => 'bmo',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/BMO%20Field.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9CTU8gRmllbGQucG5nIiwiaWF0IjoxNzQwMzMxMjEzLCJleHAiOjE4MDM0MDMyMTN9.XLQCXcs8SKJr6VgWbRbpT_7TClmMAy1ZXfdxgxitFkA'
			],
			[
				'name' => 'Estadio Akron',
				'key' => 'akron',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Estadio%20Akron.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9Fc3RhZGlvIEFrcm9uLnBuZyIsImlhdCI6MTc0MDMzMTIzNSwiZXhwIjoxODAzNDAzMjM1fQ.qwXh3lIk5l5YEwyMFC9nXDM8BcSj4iTlOhi-lK89sts'
			],
			[
				'name' => 'Estadio Azteca',
				'key' => 'azteca',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Estadio%20Azteca.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9Fc3RhZGlvIEF6dGVjYS5wbmciLCJpYXQiOjE3NDAzMzEyNTAsImV4cCI6MTgwMzQwMzI1MH0.AmTrMtS0xUP3MaN4-dz21nzSLz0JCKZ8mMkRtA4KdX8'
			],
			[
				'name' => 'Estadio BBVA',
				'key' => 'bbva',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Estadio%20BBVA.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9Fc3RhZGlvIEJCVkEucG5nIiwiaWF0IjoxNzQwMzMxMjYxLCJleHAiOjE4MDM0MDMyNjF9.Dc-GqPR4fSEOZAPc-DCM0SlMI5UQGUms213xnYFzZ6M'
			],
			[
				'name' => 'Gillette Stadium',
				'key' => 'gillette',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Gillette%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9HaWxsZXR0ZSBTdGFkaXVtLnBuZyIsImlhdCI6MTc0MDMzMTI3NSwiZXhwIjoxODAzNDAzMjc1fQ.3ZJMO6qBKkYAigNggyvNyk_HAsjXfqGi-aaF9l2t3h0'
			],
			[
				'name' => 'Hard Rock Stadium',
				'key' => 'hardrock',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Hard%20Rock%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9IYXJkIFJvY2sgU3RhZGl1bS5wbmciLCJpYXQiOjE3NDAzMzEyODgsImV4cCI6MTgwMzQwMzI4OH0.R8RSWUS-hhzM90W0JDngf4fGmUnB2ajgn-jHBg_innY'
			],
			[
				'name' => 'Levis Stadium',
				'key' => 'levis',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Levis%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9MZXZpcyBTdGFkaXVtLnBuZyIsImlhdCI6MTc0MDMzMTMwMSwiZXhwIjoxODAzNDAzMzAxfQ.yKsNn5ape8RPbbhdMLmBbjQcVn-8HTG0yAM0gKVWavI'
			],
			[
				'name' => 'Lincoln Financial Field',
				'key' => 'lincoln',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Lincoln%20Financial%20Field.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9MaW5jb2xuIEZpbmFuY2lhbCBGaWVsZC5wbmciLCJpYXQiOjE3NDAzMzEzMTQsImV4cCI6MTgwMzQwMzMxNH0.4dD8UQq3sM8LQTFuHlesnWRzEEBuVlSq_v8LB4sWwKQ'
			],
			[
				'name' => 'Lumen Field',
				'key' => 'lumen',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Lumen%20Field.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9MdW1lbiBGaWVsZC5wbmciLCJpYXQiOjE3NDAzMzEzMjgsImV4cCI6MTgwMzQwMzMyOH0.Oq48rw5JwaYthBERR0khjPX7_08DB_wh48vdK14LG6Y'
			],
			[
				'name' => 'Mercedes-Benz Stadium',
				'key' => 'mercedes',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/Mercedes-Benz%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9NZXJjZWRlcy1CZW56IFN0YWRpdW0ucG5nIiwiaWF0IjoxNzQwMzMxMzM5LCJleHAiOjE4MDM0MDMzMzl9.RIkw3bZLWxZhD1I_jtJMQfIwbE-xA4zfH51jImFFXKw'
			],
			[
				'name' => 'MetLife Stadium',
				'key' => 'metlife',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/MetLife%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9NZXRMaWZlIFN0YWRpdW0ucG5nIiwiaWF0IjoxNzQwMzMxMzUwLCJleHAiOjE4MDM0MDMzNTB9.B7fak4mtYlvAHV_5A7MpO2IHdhzXW88vNfXE92xdEqs'
			],
			[
				'name' => 'NRG Stadium',
				'key' => 'nrg',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/NRG%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9OUkcgU3RhZGl1bS5wbmciLCJpYXQiOjE3NDAzMzEzNjEsImV4cCI6MTgwMzQwMzM2MX0.7qEEMBt7ba6ywZtHEkp_axfCwNSeZrCiwNc0595HMxk'
			],
			[
				'name' => 'SoFi Stadium',
				'key' => 'sofi',
				'url' => 'https://owezibfqjgnvzaebqvii.supabase.co/storage/v1/object/sign/stadiums/SoFi%20Stadium.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzdGFkaXVtcy9Tb0ZpIFN0YWRpdW0ucG5nIiwiaWF0IjoxNzQwMzMxMzcyLCJleHAiOjE4MDM0MDMzNzJ9.IY-1eN9FRZ6ENat8BBVgj4Slr_ERIw7jArN957N-lY0'
			],
		];
	}
}
