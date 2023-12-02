<?php

namespace App\Http\Services;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionService
{
    /**
     * Transaction bulk action
     *
     * @param Request $request
     * @return array
     */
    public function bulktAction(Request $request) :array{

        $response =  response_status('Successfully updated currency status');
        $bulkIds = $request->get('bulk_id');

        if($request->get("type") == 'restore'){
            $response =  response_status('Transaction have been successfully Restored.');
            $transactions = Transaction::withTrashed()->whereIn('id',$bulkIds)->get();
            foreach($transactions as $transaction){
                $this->restore($transaction->id);
            }
        }
        else{
            $response =  response_status('Transaction has been successfully deleted.');
            $transactions = Transaction::withTrashed()->whereIn('id',$bulkIds)->get()->chunk(site_settings('chunk_value'));;
            foreach($transactions as $transactionChunks){
                foreach ($transactionChunks as $transaction)
                $this->delete($transaction->id);
            }
        }
        return $response;

    }

    public function delete($id){
        $transaction = Transaction::withTrashed()->where('id',$id)->firstOrFail();
        if ($transaction->trashed()){
            $transaction->forceDelete();
        }
        else{
            $transaction->delete();
        }
    }

    public function restore($id){
        $transaction = Transaction::withTrashed()->where('id',$id)->first();
        $transaction->restore();
    }
}
