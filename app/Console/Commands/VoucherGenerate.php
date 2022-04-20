<?php

namespace App\Console\Commands;

use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Sale\Voucher;
use App\Models\Shop\Consultation;
use Illuminate\Console\Command;

class VoucherGenerate extends Command
{
    /**
     * @var string[]
     */
    private $codes = [
        'YN01-83ew',
        'DL38-62mc',
        'wp17-21fI',
        'VL40-36TE',
        'nu70-18nh',
        'Gp78-59YM',
        'YW06-54vv',
        'ja59-78wZ',
        'sN42-77CP',
        'TH16-55fJ',
        'xo11-43Ak',
        'MO16-38Is',
        'se93-73SA',
        'pe65-94Ul',
        'GU52-88KB',
        'nK95-24Fo',
        'Fv67-68nO',
        'aH50-10op',
        'fG79-83hU',
        'mJ96-61vB',
        'jz45-16LB',
        'YA32-56GD',
        'vn90-67Mk',
        'On76-66tU',
        'OC98-71Pd',
        'ci90-03RB',
        'Sf54-49He',
        'cW43-47pd',
        'Of17-06XO',
        'wr31-23pe',
        'Wk31-23ZN',
        'FE17-12oc',
        'Ja72-66EO',
        'yB07-18hq',
        'JM37-73AA',
        'PT76-74Ao',
        'cx26-88hb',
        'yQ91-52Mh',
        'Mk14-22Ym',
        'MK98-52RJ',
        'll93-13nK',
        'Kc18-12UE',
        'nc72-83PW',
        'rn53-46bB',
        'id49-05xt',
        'Pz00-03LS',
        'Do15-67Qp',
        'Uy09-29Ik',
        'fg25-95fz',
        'mr99-95Ro'
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voucher:generate { --formation=} {--product=} {--consultation=} {--code=} {--codes=} {--count=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to test timezone';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $formation = $this->option('formation');
        $product = $this->option('product');
        $consultation = $this->option('consultation');
        $count = $this->option('count');
        $code = $this->option('code');
        $codes = (bool) $this->option('codes');
        $model = null;
        if($formation){
            $model = Formation::find($formation);
        }elseif ($product){
            $model = Product::find($product);
        }elseif ($consultation){
            $model = Consultation::find($consultation);
        }

        if($model){
            if(!empty($code)){
                $voucher = Voucher::whereCode($code)->first();
                if($voucher){
                    $this->error("Le code $code existe déjà!");
                }else{
                    $voucher = Voucher::create([
                        'model_id' => $model->getKey(),
                        'model_type' => $model->getMorphClass(),
                        'code' => $code,
                        'data' => [],
                        'expires_at' => null,
                    ]);
                    if($voucher){
                        $this->info("Le code cadeau $code est créé avec succès!");
                    }
                }
            }else if ($codes) {
                foreach ($this->codes as $code){
                    $code = strtoupper(trim($code));

                    /** @var Voucher $voucher */
                    $voucher = Voucher::updateOrCreate(
                        [
                            'code' => $code,
                        ],
                        [
                            'model_id' => $model->getKey(),
                            'model_type' => $model->getMorphClass(),
                            'data' => [],
                            'expires_at' => null,
                        ]
                    );
                    if($voucher->wasRecentlyCreated){
                        $this->info("Le code cadeau $code est créé avec succès!");
                    }else{
                        $this->warn("Le code cadeau $code été mis à jour avec succès!");
                    }
                }
            } else {
                $vouchers = $model->createVouchers($count);
                $this->info("Les $count codes cadeaux sont créés avec succès!");
                foreach ($vouchers as $voucher){
                    $this->warn($voucher->code);
                }
            }
        }else{
            $this->error("Le produit/formation/consultation est introuvable!");
        }

        return 0;
    }
}
